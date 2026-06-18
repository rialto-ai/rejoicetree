<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Public marketing pages for Rejoice Pages.
 *
 * These pages describe the product to prospective Christian creators and
 * ministries. They are intentionally self-contained (their own calm, light
 * layout) so they render reliably regardless of the active user theme.
 */
class RejoicePagesController extends Controller
{
    // /pages
    public function index()
    {
        return view('rejoice.landing');
    }

    // /pages/faq
    public function faq()
    {
        return view('rejoice.faq');
    }

    // /pages/create
    public function create()
    {
        return view('rejoice.create');
    }

    // /pages/examples
    public function examples()
    {
        $examples = [
            ['slug' => 'demo-artist', 'name' => 'Demo Artist', 'type' => 'Christian Artist'],
            ['slug' => 'demo-podcast', 'name' => 'Demo Podcast', 'type' => 'Podcaster'],
            ['slug' => 'demo-ministry', 'name' => 'Demo Ministry', 'type' => 'Ministry'],
            ['slug' => 'demo-builder', 'name' => 'Demo Builder', 'type' => 'Rejoice Builder'],
        ];

        return view('rejoice.examples', ['examples' => $examples]);
    }

    // GET /pages/creator-waitlist
    public function waitlist()
    {
        return view('rejoice.waitlist');
    }

    // POST /pages/creator-waitlist
    public function joinWaitlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:190',
            'page_type' => 'nullable|string|max:60',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('rejoice.waitlist')
                ->withErrors($validator)
                ->withInput();
        }

        $entry = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'page_type' => $request->input('page_type'),
            'notes' => $request->input('notes'),
            'created_at' => now()->toIso8601String(),
        ];

        // MVP storage: append to a JSON lines file. A dedicated table can be
        // introduced later without changing this public-facing flow.
        Storage::disk('local')->append('creator-waitlist.jsonl', json_encode($entry));

        return redirect()->route('rejoice.waitlist')->with('waitlist_joined', true);
    }

    // GET /report-page/{slug} — public "Report this page" form
    public function reportForm($slug)
    {
        $page = \App\Models\User::where('littlelink_name', $slug)->firstOrFail();

        return view('rejoice.report', [
            'page' => $page,
            'reasons' => config('rejoice.flag_reasons'),
        ]);
    }

    // POST /report-page/{slug}
    public function submitReport(Request $request, $slug)
    {
        $page = \App\Models\User::where('littlelink_name', $slug)->firstOrFail();

        $data = $request->validate([
            'reason' => ['required', Rule::in(config('rejoice.flag_reasons'))],
            'description' => 'nullable|string|max:2000',
            'reporter_email' => 'nullable|email|max:190',
        ]);

        \App\Models\PageReport::create([
            'page_id' => $page->id,
            'reason' => $data['reason'],
            'description' => $data['description'] ?? null,
            'reporter_email' => $data['reporter_email'] ?? null,
            'status' => 'Open',
        ]);

        return redirect()->route('rejoice.report.form', ['slug' => $slug])->with('report_sent', true);
    }
}

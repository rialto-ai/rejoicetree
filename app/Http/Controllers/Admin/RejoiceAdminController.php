<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CreatorProfile;
use App\Models\Link;
use App\Models\PageReport;
use App\Models\ReviewNote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Rejoice admin / reviewer tooling: page review, verification, flagged
 * reports, support-link review, audio onboarding, and global settings.
 */
class RejoiceAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless(Auth::check() && Auth::user()->isRejoiceReviewer(), 403);
            return $next($request);
        });
    }

    public function creators()
    {
        $profiles = CreatorProfile::with('user')->orderByDesc('updated_at')->paginate(50);

        return view('admin.rejoice.creators', ['profiles' => $profiles]);
    }

    public function pending()
    {
        $pages = CreatorProfile::with('user')
            ->whereIn('review_status', ['Pending Review', 'Needs Changes'])
            ->orderByDesc('updated_at')->get();

        $links = Link::whereIn('review_status', ['Unreviewed', 'Flagged'])
            ->whereNotNull('block_type')->where('review_required', true)->get();

        return view('admin.rejoice.pending', ['pages' => $pages, 'links' => $links]);
    }

    public function flagged()
    {
        $reports = PageReport::with(['page', 'link'])->where('status', 'Open')
            ->orderByDesc('created_at')->get();
        $flaggedLinks = Link::where('review_status', 'Flagged')->get();

        return view('admin.rejoice.flagged', ['reports' => $reports, 'flaggedLinks' => $flaggedLinks]);
    }

    public function verification()
    {
        $profiles = CreatorProfile::with('user')->orderByDesc('updated_at')->paginate(50);

        return view('admin.rejoice.verification', [
            'profiles' => $profiles,
            'states' => config('rejoice.verification_states'),
        ]);
    }

    public function audioOnboarding()
    {
        $profiles = CreatorProfile::with('user')
            ->where('rejoice_audio_status', '!=', 'Coming Soon')->get();

        return view('admin.rejoice.audio', [
            'profiles' => $profiles,
            'states' => config('rejoice.rejoice_audio_states'),
        ]);
    }

    public function supportLinks()
    {
        $links = Link::where('block_type', 'Support')->orderByDesc('updated_at')->get();

        return view('admin.rejoice.support', [
            'links' => $links,
            'linkStates' => config('rejoice.link_review_states'),
        ]);
    }

    public function settings()
    {
        return view('admin.rejoice.settings', [
            'settings' => [
                'require_review_before_publish' => rejoice_setting('require_review_before_publish'),
                'require_review_for_support_links' => rejoice_setting('require_review_for_support_links'),
                'show_ai_disclosure_publicly' => rejoice_setting('show_ai_disclosure_publicly'),
                'show_verification_badges_publicly' => rejoice_setting('show_verification_badges_publicly'),
                'allow_custom_domains' => rejoice_setting('allow_custom_domains'),
                'allow_public_signup' => rejoice_setting('allow_public_signup'),
                'allow_ministry_pages' => rejoice_setting('allow_ministry_pages'),
            ],
        ]);
    }

    // --- Actions -----------------------------------------------------------

    public function updateReview(Request $request, $userId)
    {
        $data = $request->validate([
            'review_status' => ['required', Rule::in(config('rejoice.page_review_states'))],
            'note' => 'nullable|string|max:2000',
        ]);

        $profile = CreatorProfile::where('user_id', $userId)->firstOrFail();
        $profile->review_status = $data['review_status'];
        $profile->save();

        if (!empty($data['note'])) {
            ReviewNote::create([
                'page_id' => $userId,
                'admin_id' => Auth::id(),
                'note' => $data['note'],
                'status' => $data['review_status'],
            ]);
        }

        // Notify the creator of the outcome.
        $email = optional($profile->user)->email;
        if ($data['review_status'] === 'Approved') {
            \App\Mail\RejoiceNotification::sendTo($email, 'approved');
        } elseif ($data['review_status'] === 'Needs Changes') {
            \App\Mail\RejoiceNotification::sendTo($email, 'changes');
        }

        return back()->with('success', "Page review status set to {$data['review_status']}.");
    }

    public function updateVerification(Request $request, $userId)
    {
        $data = $request->validate([
            'verification_status' => ['required', Rule::in(config('rejoice.verification_states'))],
        ]);

        $profile = CreatorProfile::where('user_id', $userId)->firstOrFail();
        $profile->verification_status = $data['verification_status'];
        $profile->save();

        return back()->with('success', "Verification set to {$data['verification_status']}.");
    }

    public function updateAudio(Request $request, $userId)
    {
        $data = $request->validate([
            'rejoice_audio_status' => ['required', Rule::in(config('rejoice.rejoice_audio_states'))],
        ]);

        $profile = CreatorProfile::where('user_id', $userId)->firstOrFail();
        $profile->rejoice_audio_status = $data['rejoice_audio_status'];
        $profile->save();

        return back()->with('success', "Rejoice Audio status set to {$data['rejoice_audio_status']}.");
    }

    public function updateLink(Request $request, $linkId)
    {
        $data = $request->validate([
            'review_status' => ['required', Rule::in(config('rejoice.link_review_states'))],
        ]);

        $link = Link::findOrFail($linkId);
        $link->review_status = $data['review_status'];
        $link->save();

        return back()->with('success', "Link review status set to {$data['review_status']}.");
    }

    public function resolveReport(Request $request, $reportId)
    {
        $report = PageReport::findOrFail($reportId);
        $report->status = $request->input('status', 'Resolved');
        $report->reviewed_by = Auth::id();
        $report->reviewed_at = now();
        $report->save();

        return back()->with('success', 'Report updated.');
    }

    public function saveSettings(Request $request)
    {
        $keys = [
            'require_review_before_publish',
            'require_review_for_support_links',
            'show_ai_disclosure_publicly',
            'show_verification_badges_publicly',
            'allow_custom_domains',
            'allow_public_signup',
            'allow_ministry_pages',
        ];

        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $request->boolean($key);
        }
        set_rejoice_settings($values);

        return back()->with('success', 'Settings saved.');
    }
}

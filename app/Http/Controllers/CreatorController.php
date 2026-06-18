<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Creator-facing Rejoice profile, onboarding and analytics screens.
 * All actions operate on the authenticated user's CreatorProfile.
 */
class CreatorController extends Controller
{
    public function onboarding()
    {
        $profile = Auth::user()->profile();

        return view('creator.onboarding', [
            'profile' => $profile,
            'pageTypes' => config('rejoice.page_types'),
            'templates' => config('rejoice.templates'),
        ]);
    }

    public function profile()
    {
        $profile = Auth::user()->profile();

        return view('creator.profile', [
            'profile' => $profile,
            'pageTypes' => config('rejoice.page_types'),
            'authorshipStates' => config('rejoice.human_authorship_states'),
            'aiUseLevels' => config('rejoice.ai_use_levels'),
            'audioStates' => config('rejoice.rejoice_audio_states'),
        ]);
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'page_type' => ['nullable', Rule::in(config('rejoice.page_types'))],
            'short_bio' => 'nullable|string|max:2000',
            'location' => 'nullable|string|max:160',
            'primary_category' => 'nullable|string|max:120',
            'website' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:190',
            'management_contact' => 'nullable|string|max:190',
            'booking_contact' => 'nullable|string|max:190',
            'testimony' => 'nullable|string|max:5000',
            'church_affiliation' => 'nullable|string|max:190',
            'ministry_affiliation' => 'nullable|string|max:190',
            'statement_of_faith_url' => 'nullable|url|max:255',
            'publisher_or_label' => 'nullable|string|max:190',
            'partner_organizations' => 'nullable|string|max:2000',
            'supported_causes' => 'nullable|string|max:2000',
            'human_authorship_status' => ['nullable', Rule::in(config('rejoice.human_authorship_states'))],
            'ai_use_level' => ['nullable', Rule::in(config('rejoice.ai_use_levels'))],
            'ai_use_disclosure_text' => 'nullable|string|max:3000',
            'synthetic_voice_used' => 'nullable|boolean',
            'synthetic_persona_used' => 'nullable|boolean',
            'rejoice_audio_interest' => 'nullable|string|max:120',
        ]);

        $profile = Auth::user()->profile();
        $profile->fill($validated);
        $profile->synthetic_voice_used = $request->boolean('synthetic_voice_used');
        $profile->synthetic_persona_used = $request->boolean('synthetic_persona_used');

        // Translate the simple Rejoice Audio interest answer into onboarding state.
        if ($request->filled('rejoice_audio_interest') && $request->input('rejoice_audio_interest') !== 'Not yet') {
            $profile->rejoice_audio_status = 'Onboarding';
        }

        if ($profile->creator_onboarding_status === 'Not Started') {
            $profile->creator_onboarding_status = 'In Progress';
        }

        $profile->save();

        return redirect()->route('creator.profile')->with('success', 'Your Rejoice profile has been saved.');
    }

    /**
     * Submit the page for review (or publish, depending on the global setting).
     */
    public function submitForReview()
    {
        $profile = Auth::user()->profile();

        if (rejoice_setting('require_review_before_publish')) {
            $profile->review_status = 'Pending Review';
            $profile->creator_onboarding_status = 'Submitted for Review';
            $message = 'Your Rejoice Page has been submitted for review.';
        } else {
            $profile->review_status = 'Approved';
            $profile->creator_onboarding_status = 'Published';
            $message = 'Your Rejoice Page is now published.';
        }

        $profile->save();

        if ($profile->review_status === 'Pending Review') {
            \App\Mail\RejoiceNotification::sendTo(Auth::user()->email, 'submitted');
        } else {
            \App\Mail\RejoiceNotification::sendTo(Auth::user()->email, 'approved');
        }

        return redirect()->route('creator.profile')->with('success', $message);
    }

    public function analytics()
    {
        $user = Auth::user();
        $links = \App\Models\Link::where('user_id', $user->id)->get();

        $clicksByBlock = $links->groupBy('block_type')->map(fn ($g) => $g->sum('click_number'));
        $topLinks = $links->sortByDesc('click_number')->take(10);

        return view('creator.analytics', [
            'user' => $user,
            'totalClicks' => $links->sum('click_number'),
            'topLinks' => $topLinks,
            'clicksByBlock' => $clicksByBlock,
        ]);
    }
}

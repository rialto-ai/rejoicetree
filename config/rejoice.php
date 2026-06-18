<?php

/*
|--------------------------------------------------------------------------
| Rejoice Pages configuration
|--------------------------------------------------------------------------
|
| Central source of truth for the Rejoice-specific taxonomies (page types,
| verification states, link block types, moderation statuses, etc.) used by
| onboarding, public pages, and the admin review workflows.
|
*/

return [

    // Rejoice user roles (separate from LinkStack's core access role).
    'roles' => [
        'Creator',
        'Ministry Admin',
        'Reviewer',
        'Rejoice Admin',
        'Super Admin',
    ],

    // Roles that may access the Rejoice admin / review tooling.
    'admin_roles' => ['Reviewer', 'Rejoice Admin', 'Super Admin'],

    'page_types' => [
        'Artist',
        'Worship Leader',
        'Podcaster',
        'Author',
        'Speaker',
        'Pastor / Teacher',
        'Ministry',
        'Church',
        'Publisher',
        'Audiobook Creator',
        'Event',
        'Mission Partner',
        'Rejoice Builder',
        'Project',
        'Other',
    ],

    'verification_states' => [
        'Unverified',
        'Email Verified',
        'Identity Verified',
        'Creator Verified',
        'Ministry Verified',
        'Rejoice Reviewed',
        'Partner Verified',
        'Suspended',
    ],

    // Verification states that produce a public badge, and their label.
    'verification_badges' => [
        'Creator Verified' => 'Verified Creator',
        'Ministry Verified' => 'Verified Ministry',
        'Rejoice Reviewed' => 'Rejoice Reviewed',
        'Partner Verified' => 'Partner Verified',
    ],

    'page_review_states' => [
        'Draft',
        'Pending Review',
        'Approved',
        'Needs Changes',
        'Rejected',
        'Suspended',
    ],

    'link_review_states' => [
        'Unreviewed',
        'Approved',
        'Flagged',
        'Hidden',
        'Rejected',
    ],

    'human_authorship_states' => [
        'Not Provided',
        'Human Authorship Confirmed',
        'AI-Assisted Disclosed',
        'Needs Review',
        'Not Eligible',
    ],

    'ai_use_levels' => [
        'None Disclosed',
        'AI-Assisted Writing',
        'AI-Assisted Production',
        'AI-Assisted Translation',
        'AI-Generated Voice',
        'AI-Generated Image',
        'Synthetic Persona',
        'Other',
    ],

    'rejoice_audio_states' => [
        'Coming Soon',
        'Onboarding',
        'Submitted',
        'Reviewed',
        'Live',
    ],

    'onboarding_states' => [
        'Not Started',
        'In Progress',
        'Submitted for Review',
        'Published',
    ],

    'block_types' => [
        'Music',
        'Podcast',
        'Book / Audiobook',
        'Sermon / Teaching',
        'Video',
        'Event',
        'Newsletter',
        'Support',
        'Booking',
        'Media Kit',
        'Testimony',
        'Ministry',
        'Church',
        'Cause',
        'Rejoice Audio',
        'Rejoice Builder Project',
        'Custom Link',
    ],

    'support_types' => [
        'Personal Support',
        'Ministry Donation',
        'Church Giving',
        'Merch',
        'Ticketing',
        'Membership',
        'Fundraiser',
        'Sponsor',
        'Other',
    ],

    'booking_types' => [
        'Speaking',
        'Worship Leading',
        'Podcast Guest',
        'Concert',
        'Church Event',
        'Conference',
        'Interview',
        'Consultation',
        'Other',
    ],

    'flag_reasons' => [
        'Spam',
        'Impersonation',
        'Unsafe Content',
        'Theological Concern',
        'Child Safety Concern',
        'Misleading Affiliation',
        'Undisclosed AI Use',
        'Copyright Concern',
        'Fraudulent Donation Link',
        'Broken Link',
        'Other',
    ],

    // Block-specific field keys, stored as JSON in links.block_params.
    'block_fields' => [
        'Music' => ['spotify_url', 'apple_music_url', 'youtube_music_url', 'bandcamp_url', 'soundcloud_url', 'rejoice_audio_url', 'latest_release_url'],
        'Podcast' => ['apple_podcast_url', 'spotify_podcast_url', 'rss_url', 'youtube_url', 'rejoice_audio_url', 'latest_episode_url'],
        'Book / Audiobook' => ['book_url', 'publisher_url', 'amazon_url', 'audible_url', 'audiobook_sample_url', 'rejoice_audio_url'],
        'Sermon / Teaching' => ['church_url', 'sermon_archive_url', 'series_url', 'youtube_url', 'podcast_url', 'resource_url'],
        'Event' => ['event_name', 'event_date', 'venue', 'city', 'ticket_url', 'registration_url', 'booking_url'],
        'Support' => ['support_type', 'support_url', 'support_entity_name', 'tax_deductible_claimed', 'tax_status_description', 'review_required'],
        'Booking' => ['booking_type', 'booking_url', 'booking_email', 'booking_packet_url'],
        'Media Kit' => ['press_kit_url', 'sponsorship_deck_url', 'booking_packet_url', 'bio_pdf_url', 'photos_url', 'contact_email'],
        'Rejoice Audio' => ['status', 'profile_url', 'artist_id', 'podcast_id', 'audiobook_id', 'submission_url'],
    ],

    // Default section templates per page type (Phase 3).
    'templates' => [
        'Artist' => ['Music', 'Latest Release', 'Events', 'Testimony', 'Support', 'Booking', 'Media Kit', 'Rejoice Audio', 'Social Links'],
        'Podcaster' => ['Latest Episode', 'Podcast Platforms', 'Newsletter', 'Support', 'Booking', 'Media Kit', 'Rejoice Audio'],
        'Author' => ['Books', 'Audiobooks', 'Newsletter', 'Speaking', 'Media Kit', 'Support'],
        'Speaker' => ['Teaching', 'Sermons', 'Booking', 'Media Kit', 'Church / Ministry Affiliation', 'Newsletter'],
        'Pastor / Teacher' => ['Teaching', 'Sermons', 'Booking', 'Media Kit', 'Church / Ministry Affiliation', 'Newsletter'],
        'Ministry' => ['Mission', 'Resources', 'Donate', 'Events', 'Volunteer', 'Podcast / Sermons', 'Updates', 'Partner With Us'],
        'Event' => ['Tickets', 'Schedule', 'Speakers', 'Venue', 'Sponsors', 'Volunteer', 'Resources'],
        'Mission Partner' => ['Mission', 'Resources', 'Updates', 'Support', 'Contact', 'Reports'],
        'Rejoice Builder' => ['Project', 'GitHub', 'Demo', 'Docs', 'Team', 'Request Support', 'Apply to Builders'],
    ],

    // Global settings (overridable via the admin Settings screen / env).
    'settings' => [
        'require_review_before_publish' => env('REJOICE_REQUIRE_REVIEW', true),
        'require_review_for_support_links' => env('REJOICE_REVIEW_SUPPORT_LINKS', true),
        'show_ai_disclosure_publicly' => env('REJOICE_SHOW_AI_DISCLOSURE', false),
        'show_verification_badges_publicly' => env('REJOICE_SHOW_BADGES', true),
        'allow_custom_domains' => env('REJOICE_ALLOW_CUSTOM_DOMAINS', false),
        'allow_public_signup' => env('REJOICE_ALLOW_PUBLIC_SIGNUP', true),
        'allow_ministry_pages' => env('REJOICE_ALLOW_MINISTRY_PAGES', true),
    ],
];

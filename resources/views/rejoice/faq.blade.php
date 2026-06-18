@extends('rejoice.layout')

@section('title', 'FAQ')
@section('meta_description', 'Answers to common questions about Rejoice Pages, the trusted profile layer for Christian creators and ministries.')

@section('content')
<section style="border-bottom:0;">
    <div class="container">
        <h1>Frequently asked questions</h1>

        @php
        $faqs = [
            ['What is Rejoice Pages?',
             'Rejoice Pages is a simple public profile page for Christian creators, artists, ministries, podcasters, authors, speakers, and churches. It lets you share your important links, content, testimony, support options, events, bookings, and Rejoice Audio profile in one place.'],
            ['Is this like Linktree?',
             'In the simple sense, yes. Rejoice Pages gives you one page for many links. But it is built specifically for Christian creators and ministries, with support for testimony, ministry links, Rejoice Audio, media kits, bookings, content integrity, and mission-aligned profiles.'],
            ['Who should use Rejoice Pages?',
             'Christian artists, worship leaders, podcasters, authors, speakers, pastors, ministries, publishers, events, mission partners, and Rejoice Builders.'],
            ['What can I put on my page?',
             'Music, podcasts, books, sermons, videos, events, newsletters, donation links, booking links, social profiles, media kits, ministry pages, church links, and supported causes.'],
            ['Is this a full website?',
             'No. Rejoice Pages is a simple creator or ministry profile. It can replace a basic link-in-bio page, but creators who need a full website can still use one alongside it.'],
            ['How does this connect to Rejoice Audio?',
             'Rejoice Pages is designed to become the public profile layer for Rejoice Audio creators. A listener can discover an artist, podcast, sermon, or audiobook and then visit the creator\'s page for more links, events, support options, and ministry context.'],
            ['Can ministries use it?',
             'Yes. Ministries can use Rejoice Pages for campaigns, resources, podcast links, sermon series, giving pages, volunteer pathways, events, and partner updates.'],
            ['Can I collect emails?',
             'At launch, Rejoice Pages can link to your existing newsletter tool. Native email capture may be added later.'],
            ['Can I use my own domain?',
             'Custom domain support should be supported where the underlying infrastructure allows it. This may be added after the first MVP.'],
            ['Does Rejoice process donations?',
             'Not by default. At launch, support links usually point to existing giving, donation, membership, merch, or ticketing tools. Rejoice only processes payments when clearly stated.'],
            ['What is creator verification?',
             'Verification helps audiences know when a creator, ministry, or partner page has been reviewed or confirmed by Rejoice.'],
            ['What is human-authorship disclosure?',
             'It is an optional disclosure that helps creators explain whether their work is human-authored, AI-assisted, or uses synthetic media. Rejoice believes human Christian witness matters.'],
            ['Is Rejoice Pages open source?',
             'Rejoice Pages is built on open-source LinkStack infrastructure with Rejoice-specific features, branding, and workflows added for Christian creators and ministries.'],
        ];
        @endphp

        @foreach ($faqs as $faq)
            <div class="faq-item">
                <h3>{{ $faq[0] }}</h3>
                <p class="muted" style="margin:0;">{{ $faq[1] }}</p>
            </div>
        @endforeach

        <div class="actions" style="margin-top:30px;">
            <a class="btn btn-primary" href="{{ route('rejoice.create') }}">Create a Page</a>
            <a class="btn btn-ghost" href="{{ route('rejoice.waitlist') }}">Join the Creator Waitlist</a>
        </div>
    </div>
</section>
@endsection

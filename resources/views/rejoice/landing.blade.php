@extends('rejoice.layout')

@section('title', 'A trusted home for Christian creators')
@section('meta_description', 'Bring your music, podcasts, books, sermons, events, support links, bookings, testimony, and ministry work into one simple page.')

@section('content')
<section>
    <div class="container">
        <h1>A trusted home for Christian creators.</h1>
        <p class="lead">
            Bring your music, podcasts, books, sermons, events, support links, bookings,
            testimony, and ministry work into one simple page.
        </p>
        <p class="lead" style="margin-top:10px;"><strong>One page. One link. A clearer way to share your work.</strong></p>
        <div class="actions">
            <a class="btn btn-primary" href="{{ route('rejoice.create') }}">Create a Page</a>
            <a class="btn btn-ghost" href="{{ route('rejoice.waitlist') }}">Join the Creator Waitlist</a>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>Built for Christian creators</h2>
        <p class="muted" style="max-width:720px;">
            Your work is scattered across platforms. Rejoice Pages gives you a simple home for
            everything you create and everything you want your audience to find.
        </p>
        <ul class="clean" style="margin-top:16px;max-width:520px;">
            <li>Share your content.</li>
            <li>Tell your story.</li>
            <li>Grow your audience.</li>
            <li>Connect people to your ministry.</li>
            <li>Prepare for Rejoice Audio.</li>
        </ul>
    </div>
</section>

<section>
    <div class="container">
        <h2>What you can add</h2>
        <div class="grid grid-4" style="margin-top:18px;">
            @foreach ([
                'Music','Podcasts','Books','Audiobooks',
                'Sermons','Videos','Events','Newsletter',
                'Support','Bookings','Media Kits','Testimony',
                'Ministry Links','Church Affiliation','Supported Causes','Rejoice Audio',
            ] as $item)
                <div class="chip">{{ $item }}</div>
            @endforeach
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>For ministries too</h2>
        <p class="muted" style="max-width:760px;">
            Rejoice Pages also works for churches, ministries, publishers, events, and mission
            partners. Use it to share resources, campaigns, sermon series, podcasts, events,
            giving pages, volunteer pathways, and partner updates.
        </p>
    </div>
</section>

<section>
    <div class="container">
        <h2>Trust</h2>
        <p class="muted" style="max-width:760px;">
            Rejoice Pages is designed for Christian creators and ministries who want their public
            presence to be clear, trustworthy, and mission-aligned.
        </p>
        <div class="grid grid-3" style="margin-top:20px;">
            <div class="card"><h3>Creator verification</h3></div>
            <div class="card"><h3>Human-authorship disclosure</h3></div>
            <div class="card"><h3>Ministry affiliation</h3></div>
            <div class="card"><h3>Support link review</h3></div>
            <div class="card"><h3>Rejoice Audio onboarding</h3></div>
        </div>
    </div>
</section>

<section style="border-bottom:0;">
    <div class="container">
        <h2>Ready to begin?</h2>
        <div class="actions">
            <a class="btn btn-primary" href="{{ route('rejoice.create') }}">Create a Page</a>
            <a class="btn btn-ghost" href="{{ route('rejoice.faq') }}">Read the FAQ</a>
        </div>
    </div>
</section>
@endsection

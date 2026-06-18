@extends('rejoice.layout')

@section('title', 'Create a Page')
@section('meta_description', 'Create your Rejoice Page in a few simple steps and share your work in one place.')

@section('content')
<section>
    <div class="container">
        <h1>Create a Page</h1>
        <p class="lead">
            Christian creators are often scattered across platforms. Rejoice Pages gives artists,
            podcasters, authors, speakers, ministries, and mission partners one simple place to
            share their work, tell their story, and connect people to the next faithful step.
        </p>
        <div class="actions">
            @if(Route::has('register'))
                <a class="btn btn-primary" href="{{ route('register') }}">Create a Page</a>
            @else
                <a class="btn btn-primary" href="{{ route('rejoice.waitlist') }}">Join the Creator Waitlist</a>
            @endif
            <a class="btn btn-ghost" href="{{ route('rejoice.examples') }}">See examples</a>
        </div>
    </div>
</section>

<section style="border-bottom:0;">
    <div class="container">
        <h2>How it works</h2>
        <div class="grid grid-2" style="margin-top:18px;">
            @php
            $steps = [
                ['1. Choose a page type', 'Artist, worship leader, podcaster, author, speaker, pastor, ministry, church, publisher, event, mission partner, or Rejoice Builder.'],
                ['2. Add your basic profile', 'Display name, page link, profile photo, short bio, and location.'],
                ['3. Tell your story', 'Add a short testimony or creator story — or a ministry description.'],
                ['4. Add your links', 'Structured blocks for music, podcasts, books, sermons, events, support, bookings, and more.'],
                ['5. Add trust details', 'Church or ministry affiliation, statement of faith, and publisher or label.'],
                ['6. Authorship & AI-use', 'Optionally provide a human-authorship and AI-use disclosure.'],
                ['7. Rejoice Audio interest', 'Let us know if you would like to join Rejoice Audio.'],
                ['8. Review & publish', 'Submit your page for review, save a draft, or publish.'],
            ];
            @endphp
            @foreach ($steps as $step)
                <div class="card">
                    <h3>{{ $step[0] }}</h3>
                    <p class="muted" style="margin:0;">{{ $step[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

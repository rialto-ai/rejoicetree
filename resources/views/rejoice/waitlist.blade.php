@extends('rejoice.layout')

@section('title', 'Creator Waitlist')
@section('meta_description', 'Join the Rejoice Pages creator waitlist and be among the first Christian creators and ministries to build a page.')

@section('content')
<section style="border-bottom:0;">
    <div class="container" style="max-width:620px;margin:0 auto;">
        <h1>Join the Creator Waitlist</h1>
        <p class="lead">
            Be among the first Christian creators and ministries to build a Rejoice Page and
            prepare for Rejoice Audio.
        </p>

        @if(session('waitlist_joined'))
            <div class="alert alert-success">
                Thank you. You are on the waitlist — we will be in touch soon.
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                Please check the form and try again.
            </div>
        @endif

        <form method="POST" action="{{ route('rejoice.waitlist.join') }}">
            @csrf
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>

            <label for="page_type">What kind of page are you creating?</label>
            <select id="page_type" name="page_type">
                <option value="">Select a page type (optional)</option>
                @foreach ([
                    'Artist','Worship Leader','Podcaster','Author','Speaker','Pastor / Teacher',
                    'Ministry','Church','Publisher','Audiobook Creator','Event','Mission Partner',
                    'Rejoice Builder','Project','Other',
                ] as $type)
                    <option value="{{ $type }}" @selected(old('page_type') === $type)>{{ $type }}</option>
                @endforeach
            </select>

            <label for="notes">Anything you'd like us to know? (optional)</label>
            <textarea id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>

            <div class="actions" style="margin-top:22px;">
                <button type="submit" class="btn btn-primary">Join the Creator Waitlist</button>
            </div>
            <p class="form-note">We will only use your email to contact you about Rejoice Pages.</p>
        </form>
    </div>
</section>
@endsection

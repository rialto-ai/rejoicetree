@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card rounded">
        <div class="card-body">
          <h3 class="mb-2 card-header"><i class="bi bi-stars"></i> Set up your Rejoice Page</h3>
          <p class="text-muted px-2">A clearer way to share your work. Follow these steps to get started.</p>

          <ol class="px-4">
            <li class="mb-2"><strong>Choose a page type</strong> — what kind of page are you creating?</li>
            <li class="mb-2"><strong>Add your basic profile</strong> — display name, link, photo, short bio, location.</li>
            <li class="mb-2"><strong>Tell your story</strong> — add a short testimony or ministry description.</li>
            <li class="mb-2"><strong>Add your links</strong> — structured blocks for music, podcasts, books, events, support and more.</li>
            <li class="mb-2"><strong>Add trust details</strong> — church/ministry affiliation, statement of faith, publisher.</li>
            <li class="mb-2"><strong>Authorship &amp; AI-use</strong> — optionally provide a disclosure.</li>
            <li class="mb-2"><strong>Rejoice Audio</strong> — tell us if you'd like to join.</li>
            <li class="mb-2"><strong>Review &amp; publish</strong> — submit your page for review.</li>
          </ol>

          @if($profile->page_type && isset($templates[$profile->page_type]))
            <div class="alert alert-info mx-2">
              <strong>Suggested sections for a {{ $profile->page_type }} page:</strong>
              {{ implode(' · ', $templates[$profile->page_type]) }}
            </div>
          @endif

          <div class="px-2">
            <a href="{{ route('creator.profile') }}" class="btn btn-primary">Edit my profile</a>
            <a href="{{ route('creator.blocks') }}" class="btn btn-outline-primary">Manage my blocks</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

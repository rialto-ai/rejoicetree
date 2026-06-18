@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card rounded">
        <div class="card-body">

          @if(session()->has('success'))
            <div class="alert alert-success">{{ session()->get('success') }}</div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">Please review the highlighted fields and try again.</div>
          @endif

          <h3 class="mb-2 card-header"><i class="bi bi-person-badge"></i> My Rejoice Page</h3>
          <p class="text-muted px-2">
            Review status: <strong>{{ $profile->review_status }}</strong> &middot;
            Verification: <strong>{{ $profile->verification_status }}</strong> &middot;
            Rejoice Audio: <strong>{{ $profile->rejoice_audio_status }}</strong>
          </p>

          <form action="{{ route('creator.profile.save') }}" method="post" class="p-2">
            @csrf

            <h4 class="mt-3">Page type</h4>
            <div class="form-group col-lg-6">
              <select name="page_type" class="form-control">
                <option value="">Select a page type</option>
                @foreach($pageTypes as $type)
                  <option value="{{ $type }}" @selected($profile->page_type === $type)>{{ $type }}</option>
                @endforeach
              </select>
            </div>

            <h4 class="mt-4">Profile</h4>
            <div class="form-group col-lg-10">
              <label>Short bio</label>
              <textarea name="short_bio" class="form-control" rows="3">{{ old('short_bio', $profile->short_bio) }}</textarea>
            </div>
            <div class="row">
              <div class="form-group col-lg-5"><label>Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $profile->location) }}"></div>
              <div class="form-group col-lg-5"><label>Primary category</label>
                <input type="text" name="primary_category" class="form-control" value="{{ old('primary_category', $profile->primary_category) }}"></div>
            </div>
            <div class="row">
              <div class="form-group col-lg-5"><label>Website</label>
                <input type="url" name="website" class="form-control" value="{{ old('website', $profile->website) }}"></div>
              <div class="form-group col-lg-5"><label>Contact email</label>
                <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $profile->contact_email) }}"></div>
            </div>
            <div class="row">
              <div class="form-group col-lg-5"><label>Management contact</label>
                <input type="text" name="management_contact" class="form-control" value="{{ old('management_contact', $profile->management_contact) }}"></div>
              <div class="form-group col-lg-5"><label>Booking contact</label>
                <input type="text" name="booking_contact" class="form-control" value="{{ old('booking_contact', $profile->booking_contact) }}"></div>
            </div>

            <h4 class="mt-4">Testimony &amp; ministry</h4>
            <div class="form-group col-lg-10">
              <label>Testimony or creator story</label>
              <textarea name="testimony" class="form-control" rows="4">{{ old('testimony', $profile->testimony) }}</textarea>
            </div>
            <div class="row">
              <div class="form-group col-lg-5"><label>Church affiliation</label>
                <input type="text" name="church_affiliation" class="form-control" value="{{ old('church_affiliation', $profile->church_affiliation) }}"></div>
              <div class="form-group col-lg-5"><label>Ministry affiliation</label>
                <input type="text" name="ministry_affiliation" class="form-control" value="{{ old('ministry_affiliation', $profile->ministry_affiliation) }}"></div>
            </div>
            <div class="row">
              <div class="form-group col-lg-5"><label>Statement of faith URL</label>
                <input type="url" name="statement_of_faith_url" class="form-control" value="{{ old('statement_of_faith_url', $profile->statement_of_faith_url) }}"></div>
              <div class="form-group col-lg-5"><label>Publisher or label</label>
                <input type="text" name="publisher_or_label" class="form-control" value="{{ old('publisher_or_label', $profile->publisher_or_label) }}"></div>
            </div>
            <div class="form-group col-lg-10"><label>Supported causes</label>
              <textarea name="supported_causes" class="form-control" rows="2">{{ old('supported_causes', $profile->supported_causes) }}</textarea></div>

            <h4 class="mt-4">Authorship &amp; AI-use disclosure</h4>
            <p class="text-muted">Optional. Rejoice believes human Christian witness matters.</p>
            <div class="row">
              <div class="form-group col-lg-5"><label>Human-authorship status</label>
                <select name="human_authorship_status" class="form-control">
                  @foreach($authorshipStates as $state)
                    <option value="{{ $state }}" @selected($profile->human_authorship_status === $state)>{{ $state }}</option>
                  @endforeach
                </select></div>
              <div class="form-group col-lg-5"><label>AI-use level</label>
                <select name="ai_use_level" class="form-control">
                  @foreach($aiUseLevels as $level)
                    <option value="{{ $level }}" @selected($profile->ai_use_level === $level)>{{ $level }}</option>
                  @endforeach
                </select></div>
            </div>
            <div class="form-group col-lg-10"><label>AI-use disclosure text</label>
              <textarea name="ai_use_disclosure_text" class="form-control" rows="2">{{ old('ai_use_disclosure_text', $profile->ai_use_disclosure_text) }}</textarea></div>
            <div class="form-check ms-2">
              <input class="form-check-input" type="checkbox" name="synthetic_voice_used" value="1" id="svu" @checked($profile->synthetic_voice_used)>
              <label class="form-check-label" for="svu">Synthetic voice used</label>
            </div>
            <div class="form-check ms-2">
              <input class="form-check-input" type="checkbox" name="synthetic_persona_used" value="1" id="spu" @checked($profile->synthetic_persona_used)>
              <label class="form-check-label" for="spu">Synthetic persona used</label>
            </div>

            <h4 class="mt-4">Rejoice Audio</h4>
            <div class="form-group col-lg-6">
              <label>Are you interested in joining Rejoice Audio?</label>
              <select name="rejoice_audio_interest" class="form-control">
                @foreach(['Not yet','Yes, I am an artist','Yes, I have a podcast','Yes, I have audiobooks','Yes, I represent a ministry'] as $opt)
                  <option value="{{ $opt }}">{{ $opt }}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="mt-4 btn btn-primary">Save profile</button>
          </form>

          <form action="{{ route('creator.submit') }}" method="post" class="p-2">
            @csrf
            <button type="submit" class="btn btn-outline-primary">Submit page for review</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

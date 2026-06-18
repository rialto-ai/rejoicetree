@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-gear"></i> Rejoice Settings</h3>
    @include('admin.rejoice._nav')

    <form action="{{ route('rejoice.admin.settings.save') }}" method="post" class="p-2">
      @csrf
      @php
      $labels = [
        'require_review_before_publish' => 'Require review before publish',
        'require_review_for_support_links' => 'Require review for support links',
        'show_ai_disclosure_publicly' => 'Show AI-use disclosure publicly',
        'show_verification_badges_publicly' => 'Show verification badges publicly',
        'allow_custom_domains' => 'Allow custom domains',
        'allow_public_signup' => 'Allow public signup',
        'allow_ministry_pages' => 'Allow ministry pages',
      ];
      @endphp
      @foreach($labels as $key => $label)
        <div class="form-check form-switch mb-2">
          <input class="form-check-input" type="checkbox" role="switch" name="{{ $key }}" value="1" id="s_{{ $key }}" @checked($settings[$key])>
          <label class="form-check-label" for="s_{{ $key }}">{{ $label }}</label>
        </div>
      @endforeach
      <button class="btn btn-primary mt-3">Save settings</button>
    </form>
  </div></div>
</div>
@endsection

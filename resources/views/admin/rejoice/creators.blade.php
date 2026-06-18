@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-people"></i> Rejoice Admin — Creators</h3>
    @include('admin.rejoice._nav')

    <table class="table">
      <thead><tr>
        <th>Name</th><th>Slug</th><th>Type</th><th>Verification</th><th>Review</th><th>Audio</th><th>Updated</th>
      </tr></thead>
      <tbody>
        @forelse($profiles as $p)
          <tr>
            <td>{{ $p->user->name ?? '—' }}</td>
            <td>@if($p->user && $p->user->littlelink_name)<a href="{{ url('@'.$p->user->littlelink_name) }}">{{ '@'.$p->user->littlelink_name }}</a>@else—@endif</td>
            <td>{{ $p->page_type ?? '—' }}</td>
            <td>{{ $p->verification_status }}</td>
            <td>{{ $p->review_status }}</td>
            <td>{{ $p->rejoice_audio_status }}</td>
            <td>{{ optional($p->updated_at)->diffForHumans() }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-muted">No creator pages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
    {{ $profiles->links() }}
  </div></div>
</div>
@endsection

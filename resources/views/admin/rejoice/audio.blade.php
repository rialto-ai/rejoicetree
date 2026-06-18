@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-broadcast"></i> Rejoice Audio Onboarding</h3>
    @include('admin.rejoice._nav')

    <table class="table">
      <thead><tr><th>Name</th><th>Slug</th><th>Type</th><th>Contact</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse($profiles as $p)
          <tr>
            <td>{{ $p->user->name ?? '—' }}</td>
            <td>@if($p->user){{ '@'.$p->user->littlelink_name }}@endif</td>
            <td>{{ $p->page_type ?? '—' }}</td>
            <td>{{ $p->contact_email ?? ($p->user->email ?? '—') }}</td>
            <td>{{ $p->rejoice_audio_status }}</td>
            <td>
              <form action="{{ route('rejoice.admin.audio.update', $p->user_id) }}" method="post" class="d-flex" style="gap:6px;">
                @csrf
                <select name="rejoice_audio_status" class="form-control form-control-sm" style="max-width:160px;">
                  @foreach($states as $s)
                    <option value="{{ $s }}" @selected($p->rejoice_audio_status === $s)>{{ $s }}</option>
                  @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Set</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-muted">No creators in Rejoice Audio onboarding yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</div>
@endsection

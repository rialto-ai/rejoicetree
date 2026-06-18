@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-hourglass-split"></i> Pending Review</h3>
    @include('admin.rejoice._nav')

    <h5 class="px-2">Pages</h5>
    @forelse($pages as $p)
      <div class="card mb-2 mx-2"><div class="card-body">
        <strong>{{ $p->user->name ?? '—' }}</strong>
        @if($p->user) <span class="text-muted">{{ '@'.$p->user->littlelink_name }}</span>@endif
        — <em>{{ $p->review_status }}</em>
        <form action="{{ route('rejoice.admin.review', $p->user_id) }}" method="post" class="mt-2 d-flex flex-wrap" style="gap:8px;">
          @csrf
          <select name="review_status" class="form-control" style="max-width:200px;">
            @foreach(config('rejoice.page_review_states') as $s)
              <option value="{{ $s }}" @selected($p->review_status === $s)>{{ $s }}</option>
            @endforeach
          </select>
          <input type="text" name="note" class="form-control" placeholder="Review note (optional)" style="max-width:340px;">
          <button class="btn btn-primary btn-sm">Update</button>
        </form>
      </div></div>
    @empty
      <p class="px-2 text-muted">No pages pending review.</p>
    @endforelse

    <h5 class="px-2 mt-4">Links needing review</h5>
    @forelse($links as $link)
      <div class="d-flex align-items-center mx-2 mb-2" style="gap:8px;">
        <span class="badge bg-soft-primary">{{ $link->block_type }}</span> {{ $link->title }}
        <form action="{{ route('rejoice.admin.link', $link->id) }}" method="post" class="d-flex" style="gap:6px;">
          @csrf
          <select name="review_status" class="form-control form-control-sm" style="max-width:160px;">
            @foreach(config('rejoice.link_review_states') as $s)
              <option value="{{ $s }}" @selected($link->review_status === $s)>{{ $s }}</option>
            @endforeach
          </select>
          <button class="btn btn-sm btn-outline-primary">Set</button>
        </form>
      </div>
    @empty
      <p class="px-2 text-muted">No links needing review.</p>
    @endforelse
  </div></div>
</div>
@endsection

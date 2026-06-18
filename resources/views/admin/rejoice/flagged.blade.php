@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-flag"></i> Flagged Pages &amp; Reports</h3>
    @include('admin.rejoice._nav')

    <h5 class="px-2">User reports</h5>
    <table class="table">
      <thead><tr><th>Page</th><th>Reason</th><th>Description</th><th>Reporter</th><th>When</th><th></th></tr></thead>
      <tbody>
        @forelse($reports as $r)
          <tr>
            <td>@if($r->page)<a href="{{ url('@'.$r->page->littlelink_name) }}">{{ '@'.$r->page->littlelink_name }}</a>@else#{{ $r->page_id }}@endif</td>
            <td>{{ $r->reason }}</td>
            <td>{{ $r->description }}</td>
            <td>{{ $r->reporter_email ?? '—' }}</td>
            <td>{{ $r->created_at->diffForHumans() }}</td>
            <td>
              <form action="{{ route('rejoice.admin.report.resolve', $r->id) }}" method="post" class="d-flex" style="gap:6px;">
                @csrf
                <select name="status" class="form-control form-control-sm" style="max-width:140px;">
                  <option value="Resolved">Resolved</option>
                  <option value="Dismissed">Dismissed</option>
                  <option value="Escalated">Escalated</option>
                </select>
                <button class="btn btn-sm btn-outline-primary">Update</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-muted">No open reports.</td></tr>
        @endforelse
      </tbody>
    </table>

    <h5 class="px-2 mt-4">Flagged links</h5>
    <ul class="px-4">
      @forelse($flaggedLinks as $link)
        <li>{{ $link->block_type ?? 'Link' }} — {{ $link->title }}</li>
      @empty
        <li class="text-muted">No flagged links.</li>
      @endforelse
    </ul>
  </div></div>
</div>
@endsection

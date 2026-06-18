@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-patch-check"></i> Verification</h3>
    @include('admin.rejoice._nav')

    <table class="table">
      <thead><tr><th>Name</th><th>Slug</th><th>Type</th><th>Verification</th><th></th></tr></thead>
      <tbody>
        @forelse($profiles as $p)
          <tr>
            <td>{{ $p->user->name ?? '—' }}</td>
            <td>@if($p->user)<a href="{{ url('@'.$p->user->littlelink_name) }}">{{ '@'.$p->user->littlelink_name }}</a>@endif</td>
            <td>{{ $p->page_type ?? '—' }}</td>
            <td>{{ $p->verification_status }}</td>
            <td>
              <form action="{{ route('rejoice.admin.verify', $p->user_id) }}" method="post" class="d-flex" style="gap:6px;">
                @csrf
                <select name="verification_status" class="form-control form-control-sm" style="max-width:200px;">
                  @foreach($states as $s)
                    <option value="{{ $s }}" @selected($p->verification_status === $s)>{{ $s }}</option>
                  @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Set</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-muted">No creator pages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
    {{ $profiles->links() }}
  </div></div>
</div>
@endsection

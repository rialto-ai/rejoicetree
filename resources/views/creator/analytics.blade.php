@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card rounded">
        <div class="card-body">
          <h3 class="mb-2 card-header"><i class="bi bi-graph-up"></i> Analytics</h3>
          <p class="text-muted px-2">Understand what people are looking for so you can serve them better.</p>

          <div class="row px-2">
            <div class="col-md-4"><div class="card"><div class="card-body">
              <h6 class="text-muted">Page views</h6>
              <h3>{{ $user->visits()->count() ?? 0 }}</h3>
            </div></div></div>
            <div class="col-md-4"><div class="card"><div class="card-body">
              <h6 class="text-muted">Link clicks</h6>
              <h3>{{ $totalClicks }}</h3>
            </div></div></div>
          </div>

          <h5 class="mt-4 px-2">Top links</h5>
          <table class="table">
            <thead><tr><th>Title</th><th>Block type</th><th class="text-end">Clicks</th></tr></thead>
            <tbody>
              @forelse($topLinks as $link)
                <tr><td>{{ $link->title }}</td><td>{{ $link->block_type ?? '—' }}</td><td class="text-end">{{ $link->click_number }}</td></tr>
              @empty
                <tr><td colspan="3" class="text-muted">No link clicks yet.</td></tr>
              @endforelse
            </tbody>
          </table>

          <h5 class="mt-4 px-2">Clicks by block type</h5>
          <table class="table">
            <tbody>
              @forelse($clicksByBlock as $type => $clicks)
                <tr><td>{{ $type ?: 'Other' }}</td><td class="text-end">{{ $clicks }}</td></tr>
              @empty
                <tr><td class="text-muted">No data yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

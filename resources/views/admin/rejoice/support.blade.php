@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="card rounded"><div class="card-body">
    <h3 class="mb-2 card-header"><i class="bi bi-cash-coin"></i> Support Links</h3>
    @include('admin.rejoice._nav')
    <p class="text-muted px-2">Review support, donation, and payment links.</p>

    <table class="table">
      <thead><tr><th>Title</th><th>Support type</th><th>Entity</th><th>Tax-deductible claimed</th><th>Review</th><th></th></tr></thead>
      <tbody>
        @forelse($links as $link)
          @php $params = $link->blockParams(); @endphp
          <tr>
            <td>{{ $link->title }}<br><small class="text-muted">{{ $link->link }}</small></td>
            <td>{{ $link->support_type ?? ($params['support_type'] ?? '—') }}</td>
            <td>{{ $link->support_entity_name ?? ($params['support_entity_name'] ?? '—') }}</td>
            <td>{{ $link->tax_deductible_claimed ? 'Yes' : 'No' }}</td>
            <td>{{ $link->review_status }}</td>
            <td>
              <form action="{{ route('rejoice.admin.link', $link->id) }}" method="post" class="d-flex" style="gap:6px;">
                @csrf
                <select name="review_status" class="form-control form-control-sm" style="max-width:140px;">
                  @foreach($linkStates as $s)
                    <option value="{{ $s }}" @selected($link->review_status === $s)>{{ $s }}</option>
                  @endforeach
                </select>
                <button class="btn btn-sm btn-primary">Set</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-muted">No support links yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div></div>
</div>
@endsection

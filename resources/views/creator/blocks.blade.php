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

          <h3 class="mb-2 card-header"><i class="bi bi-grid-1x2"></i> Blocks</h3>
          <p class="text-muted px-2">Add structured blocks to your page.</p>

          <div class="px-2 mb-3">
            <form action="{{ route('creator.blocks.create') }}" method="get" class="d-flex" style="gap:8px;max-width:480px;">
              <select name="type" class="form-control">
                @foreach($blockTypes as $bt)
                  <option value="{{ $bt }}">{{ $bt }}</option>
                @endforeach
              </select>
              <button class="btn btn-primary" type="submit">Add block</button>
            </form>
          </div>

          @if($blocks->isEmpty())
            <p class="px-2 text-muted">No blocks yet. Add your first block above.</p>
          @else
            <table class="table">
              <thead><tr><th>Type</th><th>Title</th><th>Review</th><th></th></tr></thead>
              <tbody>
                @foreach($blocks as $block)
                  <tr>
                    <td><span class="badge bg-soft-primary">{{ $block->block_type }}</span></td>
                    <td>{{ $block->title }}</td>
                    <td>{{ $block->review_status }}@if($block->review_required) <small class="text-warning">(review required)</small>@endif</td>
                    <td class="text-end">
                      <a href="{{ route('creator.blocks.edit', $block->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                      <form action="{{ route('creator.blocks.destroy', $block->id) }}" method="post" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

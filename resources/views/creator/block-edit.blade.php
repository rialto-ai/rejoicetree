@extends('layouts.sidebar')

@section('content')
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
    <div class="col-lg-12">
      <div class="card rounded">
        <div class="card-body">
          @if($errors->any())
            <div class="alert alert-danger">Please review the highlighted fields and try again.</div>
          @endif

          <h3 class="mb-2 card-header"><i class="bi bi-pencil-square"></i> {{ $block ? 'Edit' : 'Add' }} {{ $type }} block</h3>

          @if($type === 'Support')
            <div class="alert alert-info mx-2">
              Support links are provided by the creator or ministry. Rejoice does not process
              these payments unless clearly stated. If you claim tax-deductibility, your block
              will be reviewed.
            </div>
          @endif

          <form action="{{ route('creator.blocks.store') }}" method="post" class="p-2">
            @csrf
            @if($block)<input type="hidden" name="id" value="{{ $block->id }}">@endif
            <input type="hidden" name="block_type" value="{{ $type }}">

            <div class="form-group col-lg-8">
              <label>Title</label>
              <input type="text" name="title" class="form-control" value="{{ old('title', $block->title ?? '') }}" required>
            </div>
            <div class="form-group col-lg-8">
              <label>Primary URL</label>
              <input type="text" name="link" class="form-control" value="{{ old('link', $block->link ?? '') }}">
            </div>

            @if(!empty($fields))
              <h5 class="mt-3">{{ $type }} details</h5>
              @foreach($fields as $field)
                @php $val = old("params.$field", $params[$field] ?? ''); @endphp
                <div class="form-group col-lg-8">
                  <label>{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                  @if($field === 'support_type')
                    <select name="params[support_type]" class="form-control">
                      <option value="">Select a support type</option>
                      @foreach($supportTypes as $st)
                        <option value="{{ $st }}" @selected($val === $st)>{{ $st }}</option>
                      @endforeach
                    </select>
                  @elseif($field === 'booking_type')
                    <select name="params[booking_type]" class="form-control">
                      <option value="">Select a booking type</option>
                      @foreach($bookingTypes as $bt)
                        <option value="{{ $bt }}" @selected($val === $bt)>{{ $bt }}</option>
                      @endforeach
                    </select>
                  @elseif(in_array($field, ['tax_deductible_claimed','review_required']))
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="params[{{ $field }}]" value="1" id="f_{{ $field }}" @checked(!empty($val))>
                      <label class="form-check-label" for="f_{{ $field }}">Yes</label>
                    </div>
                  @else
                    <input type="text" name="params[{{ $field }}]" class="form-control" value="{{ $val }}">
                  @endif
                </div>
              @endforeach
            @endif

            <button type="submit" class="mt-3 btn btn-primary">Save block</button>
            <a href="{{ route('creator.blocks') }}" class="mt-3 btn btn-outline-secondary">Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

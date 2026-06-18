@extends('rejoice.layout')

@section('title', 'Report a page')
@section('meta_description', 'Report a Rejoice Page to the Rejoice review team.')

@section('content')
<section style="border-bottom:0;">
    <div class="container" style="max-width:620px;margin:0 auto;">
        <h1>Report this page</h1>
        <p class="lead">You are reporting <strong>{{ '@' . $page->littlelink_name }}</strong> to the Rejoice review team.</p>

        @if(session('report_sent'))
            <div class="alert alert-success">Thank you. Your report has been sent to our review team.</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">Please check the form and try again.</div>
        @endif

        <form method="POST" action="{{ route('rejoice.report.submit', ['slug' => $page->littlelink_name]) }}">
            @csrf
            <label for="reason">Reason</label>
            <select id="reason" name="reason" required>
                <option value="">Select a reason</option>
                @foreach($reasons as $reason)
                    <option value="{{ $reason }}" @selected(old('reason') === $reason)>{{ $reason }}</option>
                @endforeach
            </select>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4">{{ old('description') }}</textarea>

            <label for="reporter_email">Your email (optional)</label>
            <input type="email" id="reporter_email" name="reporter_email" value="{{ old('reporter_email') }}">

            <div class="actions" style="margin-top:22px;">
                <button type="submit" class="btn btn-primary">Send report</button>
            </div>
        </form>
    </div>
</section>
@endsection

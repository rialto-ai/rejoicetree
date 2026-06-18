@extends('rejoice.layout')

@section('title', 'Examples')
@section('meta_description', 'See example Rejoice Pages for Christian artists, podcasters, ministries, and builders.')

@section('content')
<section style="border-bottom:0;">
    <div class="container">
        <h1>Examples</h1>
        <p class="lead">
            A few example pages showing what creators and ministries can build with Rejoice Pages.
        </p>
        <div class="grid grid-2" style="margin-top:22px;">
            @foreach ($examples as $example)
                <a class="card" href="{{ url('@' . $example['slug']) }}" style="color:var(--ink);">
                    <h3>{{ $example['name'] }}</h3>
                    <p class="muted" style="margin:0;">{{ $example['type'] }} &middot; {{ '/@' . $example['slug'] }}</p>
                </a>
            @endforeach
        </div>
        <div class="actions" style="margin-top:28px;">
            <a class="btn btn-primary" href="{{ route('rejoice.create') }}">Create a Page</a>
        </div>
    </div>
</section>
@endsection

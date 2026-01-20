@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">

    <h1>{{ $post->title }}</h1>

    @if($post->published_at)
    <p>
        <p><small>Published on {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</small></p>

    </p>
    @endif

    @if($post->cover_img)
    <img src="{{ $post->cover_img }}" class="img-fluid mb-3" alt="{{ $post->title }}">
    @endif

    <div>{!! $post->body_html !!}</div>

    <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3">
        Back to Blog
    </a>

</div>
@endsection

@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <h1>Blog Posts</h1>

    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card mb-3">

                @if($post->cover_img)
                <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{!! Str::limit($post->body_html, 100) !!}</p>

                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">
                        Read More
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

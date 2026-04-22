@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Main Post -->
        <div class="col-md-8">
            <h1>{{ $post->title }}</h1>

            @if($post->published_at)
                <p><small>Published on {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</small></p>
            @endif

            @if($post->cover_img)
                <img src="{{ $post->cover_img }}" class="img-fluid mb-3" alt="{{ $post->title }}">
            @endif

            <div>{!! $post->body_html !!}</div>

            <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3">
                Back to Blog
            </a>
        </div>

        <!-- Recent Posts Sidebar -->
        <div class="col-md-4">
            <h4 class="mb-3">Recent Posts</h4>
            @if($recentPosts->count() > 0)
                @foreach($recentPosts as $recent)
                    @if($recent->id !== $post->id) <!-- Exclude current post -->
                        <div class="card mb-3 recent-post-card">
                            @if($recent->cover_img)
                                <img src="{{ $recent->cover_img }}" class="card-img-top" alt="{{ $recent->title }}">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('blog.show', $recent->slug) }}">
                                        {{ Str::limit($recent->title, 50) }}
                                    </a>
                                </h6>
                                <p class="card-text">
                                    {{ Str::limit(strip_tags($recent->body_html), 70) }}
                                </p>
                                <p class="card-text">
                                    <small>{{ \Carbon\Carbon::parse($recent->published_at)->format('d M Y') }}</small>
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <p>No recent posts.</p>
            @endif
        </div>
    </div>
</div>

<!-- Custom CSS for hover effect -->
<style>
.recent-post-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.recent-post-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}
</style>
@endsection
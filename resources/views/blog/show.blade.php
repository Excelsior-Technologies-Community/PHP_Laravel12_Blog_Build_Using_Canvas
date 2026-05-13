@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-decoration-none">Blog</a></li>
                    <li class="breadcrumb-item active">{{ $post->category ?? 'General' }}</li>
                </ol>
            </nav>

            <h1 class="fw-bold text-dark display-5 mb-3">{{ $post->title }}</h1>

            <div class="d-flex align-items-center mb-4 text-muted small">
                <span class="me-3"><i class="fa-regular fa-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</span>
                <span class="me-3"><i class="fa-solid fa-eye me-1"></i>{{ $post->views }} Views</span>
                <span class="badge bg-primary">{{ $post->category ?? 'General' }}</span>
            </div>

            @if($post->cover_img)
                <div class="mb-4">
                    <img src="{{ $post->cover_img }}" class="img-fluid shadow-sm" alt="{{ $post->title }}" style="border-radius: 20px; width: 100%; max-height: 450px; object-fit: cover;">
                </div>
            @endif

            <div class="blog-content mb-5" style="line-height: 1.8; font-size: 1.1rem; color: #444;">
                {!! $post->body_html !!}
            </div>

            <hr class="my-5">

            <div class="comments-section mb-5">
                <h3 class="fw-bold mb-4"><i class="fa-solid fa-comments text-primary me-2"></i>Comments ({{ $comments->count() }})</h3>

                <div class="card border-0 shadow-sm p-4 mb-4" style="border-radius: 15px;">
                    <h5 class="fw-bold mb-3">Leave a Reply</h5>
                    <form action="{{ route('comment.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="user_name" class="form-control border-0 bg-light" placeholder="Your Name" required style="border-radius: 10px;">
                        </div>
                        <div class="mb-3">
                            <textarea name="comment" rows="4" class="form-control border-0 bg-light" placeholder="Write your comment here..." required style="border-radius: 10px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 fw-bold" style="border-radius: 10px;">Post Comment</button>
                    </form>
                </div>

                <div class="mt-4">
                    @forelse($comments as $comment)
                        <div class="d-flex mb-4 p-3 bg-white shadow-sm" style="border-radius: 15px;">
                            <div class="flex-shrink-0">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fa-solid fa-user small"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1">{{ $comment->user_name }} <small class="text-muted fw-normal ms-2">{{ $comment->created_at->diffForHumans() }}</small></h6>
                                <p class="text-secondary mb-0">{{ $comment->comment }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted italic">No comments yet. Be the first to share your thoughts!</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px; z-index: 1;">
                <h4 class="fw-bold mb-4">Related articles</h4>
                @foreach($recentPosts as $recent)
                    <div class="card border-0 shadow-sm mb-3 overflow-hidden recent-post-card" style="border-radius: 15px;">
                        <div class="row g-0">
                            @if($recent->cover_img)
                            <div class="col-4">
                                <img src="{{ $recent->cover_img }}" class="img-fluid h-100" alt="{{ $recent->title }}" style="object-fit: cover;">
                            </div>
                            @endif
                            <div class="{{ $recent->cover_img ? 'col-8' : 'col-12' }}">
                                <div class="card-body p-3">
                                    <h6 class="card-title fw-bold mb-1" style="font-size: 0.9rem;">
                                        <a href="{{ route('blog.show', $recent->slug) }}" class="text-decoration-none text-dark stretched-link">
                                            {{ Str::limit($recent->title, 45) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($recent->published_at)->format('d M') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card border-0 bg-light p-4 mt-5 text-center" style="border-radius: 15px;">
                    <h5 class="fw-bold">Enjoying this?</h5>
                    <p class="small text-muted">Share this post with your network.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-info text-white rounded-circle" style="width: 40px; height: 40px;"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="btn btn-success rounded-circle" style="width: 40px; height: 40px;"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.recent-post-card {
    transition: all 0.3s ease;
}
.recent-post-card:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
}
.blog-content p {
    margin-bottom: 1.5rem;
}
.breadcrumb-item + .breadcrumb-item::before {
    content: "•";
    color: #ccc;
}
</style>
@endsection
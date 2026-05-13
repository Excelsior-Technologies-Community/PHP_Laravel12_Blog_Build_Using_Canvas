@extends('layouts.app')

@section('content')
<div class="container mt-5">
    @if(isset($featuredPosts) && $featuredPosts->count() > 0)
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold mb-4"><i class="fa-solid fa-star text-warning me-2"></i>Featured Posts</h2>
        </div>
        @foreach($featuredPosts as $featured)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden mb-3" style="border-radius: 15px;">
                @if($featured->cover_img)
                <img src="{{ $featured->cover_img }}" class="card-img-top" alt="{{ $featured->title }}" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <span class="badge bg-primary mb-2">{{ $featured->category ?? 'General' }}</span>
                    <h5 class="card-title fw-bold">{{ $featured->title }}</h5>
                    <a href="{{ route('blog.show', $featured->slug) }}" class="btn btn-outline-primary btn-sm mt-2">Read Featured</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <hr class="mb-5">
    @endif

    <div class="row">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold m-0">Latest Articles</h2>
                <div style="width: 300px;">
                    <input type="text" id="live-search" class="form-control border-0 shadow-sm" placeholder="🔍 Search articles..." style="border-radius: 10px;">
                </div>
            </div>

            <div class="row" id="posts-container">
                @foreach($posts as $post)
                <div class="col-md-6 post-card mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                        @if($post->cover_img)
                        <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-primary border border-primary">{{ $post->category ?? 'General' }}</span>
                                <small class="text-muted"><i class="fa-solid fa-eye me-1"></i>{{ $post->views }}</small>
                            </div>
                            <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                            <p class="card-text text-muted">{!! Str::limit(strip_tags($post->body_html), 90) !!}</p>
                            
                            @php
                                $wordCount = str_word_count(strip_tags($post->body_html));
                                $readTime = ceil($wordCount / 200);
                            @endphp
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted"><i class="fa-regular fa-clock me-1"></i>{{ $readTime }} min read</small>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary btn-sm shadow-sm" style="border-radius: 8px;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 mb-4" style="border-radius: 15px;">
                <h5 class="fw-bold mb-3">Categories</h5>
                <div class="list-group list-group-flush">
                    <a href="{{ route('blog.index') }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center">
                        All Posts <i class="fa-solid fa-chevron-right small"></i>
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat]) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex justify-content-between align-items-center">
                        {{ $cat }} <i class="fa-solid fa-chevron-right small"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 bg-primary text-white p-4 text-center shadow-sm" style="border-radius: 15px;">
                <h5 class="fw-bold">Newsletter</h5>
                <p class="small opacity-75">Subscribe to get the latest blog updates via email.</p>
                <form action="#" method="POST">
                    <input type="email" class="form-control mb-2 border-0 shadow-none text-center" placeholder="your@email.com" style="border-radius: 10px;">
                    <button type="submit" class="btn btn-light w-100 fw-bold" style="border-radius: 10px; color: #4e54c8;">Join Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $('#live-search').on('keyup', function() {
        let query = $(this).val();

        $.ajax({
            url: "{{ route('blog.search') }}",
            type: "GET",
            data: { query: query },
            success: function(data) {
                $('#posts-container').html(data.html);
            }
        });
    });
});
</script>
@endsection
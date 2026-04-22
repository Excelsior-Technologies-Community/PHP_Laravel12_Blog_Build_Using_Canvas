@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Blog Posts</h1>

    <!-- Live Search -->
    <input type="text" id="live-search" class="form-control mb-4" placeholder="Search posts...">

    <div class="row" id="posts-container">
        @foreach($posts as $post)
        <div class="col-md-4 post-card">
            <div class="card mb-3">
                @if($post->cover_img)
                <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    
                    <!-- Post Excerpt -->
                    <p class="card-text">{!! Str::limit(strip_tags($post->body_html), 100) !!}</p>

                    <!-- Read Time -->
                    @php
                        $wordCount = str_word_count(strip_tags($post->body_html));
                        $readTime = ceil($wordCount / 200); // 200 words per minute
                    @endphp
                    <small class="text-muted">Approx. {{ $readTime }} min read</small>

                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary mt-2">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- jQuery -->
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
            },
            error: function(xhr) {
                console.log('Search AJAX error:', xhr.responseText);
            }
        });
    });
});
</script>
@endsection
@if($posts->count() > 0)
<div class="row">
    @foreach($posts as $post)
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            @if($post->cover_img)
            <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                @if($post->category)
                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                @endif
                <p class="card-text mt-2">{!! Str::limit($post->body_html, 150) !!}</p>
                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Read More</a>
            </div>
            <div class="card-footer text-muted">
                Published: 
                @if($post->published_at)
                    {{ $post->published_at instanceof \Carbon\Carbon ? $post->published_at->format('d M Y') : date('d M Y', strtotime($post->published_at)) }}
                @else
                    Date not set
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

@if(method_exists($posts, 'links'))
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endif

@else
<div class="alert alert-info text-center">
    <h4>No posts found</h4>
    <p>Try searching with different keywords.</p>
</div>
@endif
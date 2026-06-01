@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-4">Blog Posts</h1>
            
            <!-- Search Form -->
            <div class="mb-4">
                <input type="text" id="search" class="form-control" placeholder="Search posts...">
            </div>
            
            <div id="posts-container">
                @include('blog.partials.posts', ['posts' => $posts])
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($categories as $category)
                            <li>
                                <a href="?category={{ $category->slug }}">
                                    {{ $category->name }} ({{ $category->posts_count }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('search').addEventListener('keyup', function() {
    let search = this.value;
    fetch(`{{ route('blog.search') }}?search=${search}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('posts-container').innerHTML = html;
    });
});
</script>
@endpush
@endsection
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Laravel Canvas Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .search-box {
            margin-bottom: 30px;
        }
        .category-sidebar {
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Laravel Canvas Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/blog">Blog</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="/logout" style="display: inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="display: inline; border: none;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-4">Blog Posts</h1>
                
                <!-- Search Form -->
                <div class="search-box">
                    <form method="GET" action="{{ route('blog.index') }}" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search posts..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                        @if(request('search'))
                            <a href="{{ route('blog.index') }}" class="btn btn-secondary ms-2">Clear</a>
                        @endif
                    </form>
                </div>

                <!-- Posts Display -->
                @if($posts->count() > 0)
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    @if($post->cover_img)
                                        <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}">
                                    @else
                                        <img src="https://via.placeholder.com/800x400?text=No+Image" class="card-img-top" alt="No image">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        @if($post->category)
                                            <span class="badge bg-primary mb-2">{{ $post->category->name }}</span>
                                        @endif
                                        <p class="card-text">{!! Str::limit(strip_tags($post->body_html), 100) !!}</p>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Read More</a>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <small>Published on: {{ date('d M Y', strtotime($post->published_at)) }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    @if(method_exists($posts, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    <div class="alert alert-info text-center">
                        <h4>No posts found!</h4>
                        <p>There are no blog posts available at the moment.</p>
                        @auth
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Create First Post</a>
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <div class="category-sidebar">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($categories) && $categories->count() > 0)
                                <ul class="list-unstyled">
                                    @foreach($categories as $category)
                                        <li class="mb-2">
                                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                                                📁 {{ $category->name }}
                                                <span class="badge bg-secondary float-end">{{ $category->posts_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No categories available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
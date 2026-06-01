@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <h1>Create New Post</h1>
    
    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label>Cover Image URL</label>
            <input type="url" name="cover_img" class="form-control" placeholder="https://example.com/image.jpg">
        </div>
        
        <div class="mb-3">
            <label>Content</label>
            <textarea name="body_html" rows="10" class="form-control" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Create Post</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
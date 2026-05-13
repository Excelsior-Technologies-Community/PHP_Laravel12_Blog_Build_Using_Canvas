@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Admin Dashboard</h2>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}! Here is your blog performance.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-file-lines fa-3x opacity-50"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1 small">Total Posts</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalPosts }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-chart-line fa-3x opacity-50"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1 small">Total Views</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalViews }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fa-solid fa-users fa-3x opacity-50"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase mb-1 small">Account Status</h6>
                        <h2 class="mb-0 fw-bold">Active</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-fire me-2"></i>Most Popular Posts</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Title</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($popularPosts as $post)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">{{ $post->title }}</td>
                                    <td><span class="badge bg-light text-primary border border-primary">{{ $post->category ?? 'General' }}</span></td>
                                    <td><i class="fa-solid fa-eye me-1 text-muted"></i>{{ $post->views }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
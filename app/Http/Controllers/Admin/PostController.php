<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with('category')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body_html' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'cover_img' => 'nullable|url'
        ]);

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'body_html' => $request->body_html,
            'cover_img' => $request->cover_img,
            'category_id' => $request->category_id,
            'published_at' => now()
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body_html' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'cover_img' => 'nullable|url'
        ]);

        $post->update([
            'title' => $request->title,
            'body_html' => $request->body_html,
            'cover_img' => $request->cover_img,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully!');
    }
}
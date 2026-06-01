<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        $posts = $query->orderBy('published_at', 'desc')->paginate(6);
        $categories = Category::withCount('posts')->get();
        
        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $recentPosts = Post::orderBy('published_at', 'desc')->limit(3)->get();
        $categories = Category::withCount('posts')->get();
        
        return view('blog.show', compact('post', 'recentPosts', 'categories'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $posts = Post::search($search)->orderBy('published_at', 'desc')->paginate(6);
        
        if ($request->ajax()) {
            return view('blog.partials.posts', compact('posts'))->render();
        }
        
        return view('blog.index', compact('posts'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|min:3'
        ]);

        Comment::create([
            'post_id' => $id,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'content' => $request->content,
            'is_approved' => false // Comments need approval
        ]);

        return redirect()->back()->with('success', 'Comment submitted for approval!');
    }
}
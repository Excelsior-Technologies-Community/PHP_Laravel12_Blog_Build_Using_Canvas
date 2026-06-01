<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();
        
        // Filter by search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('body_html', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }
        
        // Get posts with pagination
        $posts = $query->orderBy('published_at', 'desc')->paginate(6);
        
        // Get categories with post count
        $categories = Category::withCount('posts')->get();
        
        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $recentPosts = Post::orderBy('published_at', 'desc')->limit(5)->get();
        $categories = Category::withCount('posts')->get();
        
        return view('blog.show', compact('post', 'recentPosts', 'categories'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')
                     ->orWhere('body_html', 'LIKE', '%' . $search . '%')
                     ->orderBy('published_at', 'desc')
                     ->paginate(6);
        
        if ($request->ajax()) {
            return view('blog.partials.posts', compact('posts'))->render();
        }
        
        $categories = Category::withCount('posts')->get();
        return view('blog.index', compact('posts', 'categories'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|min:3'
        ]);

        $comment = new Comment();
        $comment->post_id = $id;
        $comment->author_name = $request->author_name;
        $comment->author_email = $request->author_email;
        $comment->content = $request->content;
        
        // Check if is_approved column exists
        if (Schema::hasColumn('comments', 'is_approved')) {
            $comment->is_approved = false;
        }
        
        $comment->save();

        return redirect()->back()->with('success', 'Comment submitted successfully!');
    }
}
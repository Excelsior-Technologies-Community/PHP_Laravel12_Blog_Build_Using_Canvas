<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('query');
        $category = $request->query('category');

        $posts = Post::orderBy('published_at', 'desc')
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('body_html', 'like', "%{$query}%");
            })
            ->when($category, function ($q) use ($category) {
                $q->where('category', $category);
            })
            ->get();

        $featuredPosts = Post::where('is_featured', true)->take(3)->get();
        $categories = Post::select('category')->whereNotNull('category')->distinct()->pluck('category');

        return view('blog.index', compact('posts', 'featuredPosts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        
        $post->increment('views');

        $recentPosts = Post::orderBy('published_at', 'desc')->where('id', '!=', $post->id)->take(3)->get();
        $comments = $post->comments;

        return view('blog.show', compact('post', 'recentPosts', 'comments'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

        Comment::create([
            'post_id' => $id,
            'user_name' => $request->user_name,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Comment added successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $posts = Post::where('title', 'like', "%{$query}%")
            ->orWhere('body_html', 'like', "%{$query}%")
            ->orderBy('published_at', 'desc')
            ->get();

        $html = '';
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $excerpt = strip_tags($post->body_html);
                $excerpt = Str::limit($excerpt, 100);

                $wordCount = str_word_count(strip_tags($post->body_html));
                $readTime = ceil($wordCount / 200);

                $html .= '<div class="col-md-4 post-card">
                        <div class="card mb-3">'
                    . ($post->cover_img ? '<img src="' . $post->cover_img . '" class="card-img-top" alt="' . $post->title . '">' : '') .
                    '<div class="card-body">
                                <h5 class="card-title">' . $post->title . '</h5>
                                <p class="card-text">' . $excerpt . '</p>
                                <small class="text-muted">Approx. ' . $readTime . ' min read | Views: ' . $post->views . '</small>
                                <a href="' . route('blog.show', $post->slug) . '" class="btn btn-primary mt-2 d-block">Read More</a>
                            </div>
                        </div>
                      </div>';
            }
        } else {
            $html = '<p class="text-center mt-3">No posts found.</p>';
        }

        return response()->json(['html' => $html]);
    }
}
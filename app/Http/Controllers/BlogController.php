<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    // Blog index with optional search query
    public function index(Request $request)
    {
        $query = $request->query('query');

        $posts = Post::orderBy('published_at', 'desc')
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('body_html', 'like', "%{$query}%");
            })
            ->get();

        return view('blog.index', compact('posts'));
    }

    // Show single blog post with 3 recent posts
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $recentPosts = Post::orderBy('published_at', 'desc')->take(3)->get();

        return view('blog.show', compact('post', 'recentPosts'));
    }

    
    // AJAX live search with read time
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

                // Calculate read time
                $wordCount = str_word_count(strip_tags($post->body_html));
                $readTime = ceil($wordCount / 200); // assuming 200 words per minute

                $html .= '<div class="col-md-4 post-card">
                        <div class="card mb-3">'
                    . ($post->cover_img ? '<img src="' . $post->cover_img . '" class="card-img-top" alt="' . $post->title . '">' : '') .
                    '<div class="card-body">
                                <h5 class="card-title">' . $post->title . '</h5>
                                <p class="card-text">' . $excerpt . '</p>
                                <small class="text-muted">Approx. ' . $readTime . ' min read</small>
                                <a href="' . route('blog.show', $post->slug) . '" class="btn btn-primary mt-2">Read More</a>
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

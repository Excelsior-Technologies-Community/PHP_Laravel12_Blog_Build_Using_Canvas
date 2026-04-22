<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create([
            'title' => 'My First Blog',
            'slug' => 'my-first-blog',
            'body_html' => '<p>This is the content of my first blog post. It introduces the topic and gives an overview of what to expect.</p>',
            'cover_img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Exploring Laravel Features',
            'slug' => 'exploring-laravel-features',
            'body_html' => '<p>Laravel offers a wide range of features. This post explores authentication, routing, and Blade templating.</p>',
            'cover_img' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=800&q=80',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Frontend Design Tips',
            'slug' => 'frontend-design-tips',
            'body_html' => '<p>Creating a visually appealing frontend is crucial. Here are some tips for designing responsive and modern layouts.</p>',
            'cover_img' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=800&q=80',
            'published_at' => now(),
        ]);

        Post::create([
            'title' => 'Boost Your Productivity',
            'slug' => 'boost-your-productivity',
            'body_html' => '<p>Managing time efficiently can increase your productivity. Learn some strategies and tools to stay on track.</p>',
            'cover_img' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80',
            'published_at' => now(),
        ]);
    }
}
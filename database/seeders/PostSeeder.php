<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Mastering Laravel 12 API',
                'category' => 'Technology',
                'img' => 'https://images.unsplash.com/photo-1587620962725-abab7fe55159'
            ],
            [
                'title' => 'The Future of Full-Stack Development',
                'category' => 'Coding',
                'img' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085'
            ],
            [
                'title' => 'Healthy Habits for Developers',
                'category' => 'Lifestyle',
                'img' => 'https://images.unsplash.com/photo-1506784365847-bbad939e9335'
            ],
            [
                'title' => 'Top 10 VS Code Extensions',
                'category' => 'Tools',
                'img' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713'
            ],
            [
                'title' => 'Exploring the Himalayan Mountains',
                'category' => 'Travel',
                'img' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b'
            ],
            [
                'title' => 'React vs Vue in 2026',
                'category' => 'Coding',
                'img' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee'
            ],
            [
                'title' => 'Artificial Intelligence in Daily Life',
                'category' => 'Technology',
                'img' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995'
            ],
            [
                'title' => 'Best Exercises for Back Pain',
                'category' => 'Health',
                'img' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b'
            ],
            [
                'title' => 'How to Start a Startup',
                'category' => 'Business',
                'img' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c'
            ],
            [
                'title' => 'Delicious Vegan Recipes',
                'category' => 'Food',
                'img' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd'
            ],
            [
                'title' => 'The Art of Minimalist Living',
                'category' => 'Lifestyle',
                'img' => 'https://images.unsplash.com/photo-1494438639946-1ebd1d20bf85'
            ],
            [
                'title' => 'Understanding PHP 8.4 Features',
                'category' => 'Technology',
                'img' => 'https://images.unsplash.com/photo-1599507593499-a3f7f7d9a2cc'
            ],
            [
                'title' => 'Photography Tips for Beginners',
                'category' => 'Hobbies',
                'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32'
            ],
            [
                'title' => 'Cyber Security Essentials',
                'category' => 'Security',
                'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b'
            ],
            [
                'title' => 'Deep Sea Exploration Secrets',
                'category' => 'Science',
                'img' => 'https://images.unsplash.com/photo-1551244072-5d12893278ab'
            ]
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'body_html' => '<p>This is a high-quality blog post about ' . $post['title'] . '. It covers essential details, tips, and professional advice to help readers understand the topic better. Laravel makes content management easy.</p>',
                'cover_img' => $post['img'] . '?auto=format&fit=crop&w=800&q=80',
                'category' => $post['category'],
                'is_featured' => rand(0, 1),
                'views' => rand(50, 1000),
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
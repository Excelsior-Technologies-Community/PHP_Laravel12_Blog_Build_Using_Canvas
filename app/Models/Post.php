<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body_html',
        'cover_img',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];
}

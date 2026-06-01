<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body_html',
        'cover_img',
        'published_at',
        'category_id'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Temporarily modify this to not use is_approved
    public function comments()
    {
        // Check if column exists before using it
        if (Schema::hasColumn('comments', 'is_approved')) {
            return $this->hasMany(Comment::class)->where('is_approved', true);
        }
        
        // If column doesn't exist, return all comments
        return $this->hasMany(Comment::class);
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
                     ->orWhere('body_html', 'like', '%' . $search . '%');
    }
}
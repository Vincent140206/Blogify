<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'thumbnail',
        'user_id',
        'read_time',
        'is_published',
        'published_at',
        'views'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Create a slug before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
            
            // Ensure slug is unique
            $count = static::whereRaw("slug RLIKE '^{$article->slug}(-[0-9]+)?$'")->count();
            
            if ($count > 0) {
                $article->slug = "{$article->slug}-{$count}";
            }
            
            // Calculate read time if not provided
            if (empty($article->read_time)) {
                // Average reading speed: 200 words per minute
                $wordCount = str_word_count(strip_tags($article->body));
                $article->read_time = max(1, ceil($wordCount / 200));
            }
            
            // Set published_at if not set and is_published is true
            if ($article->is_published && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    // Get excerpt from body
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->body), 200);
    }
    
    // Get comments count
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    
    // Increment view count
    public function incrementViewCount()
    {
        $this->increment('views');
    }
    
    // Scope for published articles
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }
    
    // Scope for user's articles
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

}
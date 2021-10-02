<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Taggable;

    protected $fillable = ['user_id', 'content'];

    protected $hidden = [
        'deleted_at',
        'commentable_type',
        'commentable_id',
        'user_id'
    ];

    // blog_post_id
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Foi pro Taggable.php
    // public function tags()
    // {
    //     return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    // }
    
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function(Comment $comment) {
            
    //         if($comment->commentable_type === BlogPost::class) {
                
    //             Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
    //             Cache::tags(['blog-post'])->forget("mostCommented");
    //         }
    //     });
        
    //     // static::addGlobalScope(new LatestScope);
    // }
}

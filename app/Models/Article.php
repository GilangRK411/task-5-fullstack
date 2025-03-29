<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model {
    use HasFactory;

    protected $fillable = ['title', 'slug', 'content', 'thumbnail', 'published', 'category_id', 'user_id'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($article) {
            $article->slug = Str::slug($article->title);
        });
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

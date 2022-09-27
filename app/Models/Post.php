<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    // (belongsTo)1件の記事は1人のユーザーに紐付いている
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute() {
        return Storage::url($this->image_path);
    }

    public function getImagePathAttribute() {
        return 'images/posts/' . $this->image;
    }
}
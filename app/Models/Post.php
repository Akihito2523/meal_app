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
        // 'category_id'
    ];

    // (belongsTo)1件の記事は1人のユーザーに紐付いている
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ひとつの投稿は、複数の「お気に入り」を獲得
    public function nices()
    {
        return $this->hasMany(Nice::class);
    }



    // アクセサ(リファクタリング)
    // 画像のURLを読み出し
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    // 画像のパスを読み出し
    public function getImagePathAttribute()
    {
        return 'images/posts/' . $this->image;
    }
}

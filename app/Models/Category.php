<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category'
    ];

    // (hasMany)1つのカテゴリーは複数の記事に紐付いている
    public function posts() {
        return $this->hasMany(Post::class);
    }
}

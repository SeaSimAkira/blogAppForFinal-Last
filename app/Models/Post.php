<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'status',
        'category_id',
        'user_id',
    ];

    /**
     * Post belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Post belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

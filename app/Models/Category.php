<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'parent_id', 'description', 'image', 'status'
    ];

    //Dynamic Relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}

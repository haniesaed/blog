<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $hidden = ["pivot"];
    protected $fillable = [
        "name"
    ];

    public function posts()
    {
        $this->hasMany(Post::class , "post_category");
    }
}

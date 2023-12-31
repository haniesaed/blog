<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $hidden = ["pivot"];
    protected $fillable = [
        'name',
    ];

    public function posts()
    {
        return $this->HasMany(Post::class , "post_tag");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoPost extends Model
{
    use HasFactory;

    protected $table = "post_photos";
    protected $fillable = [
      'post_id',
      'photos'
    ];

    public function post()
    {
       return  $this->belongsTo(Post::class );
    }
}

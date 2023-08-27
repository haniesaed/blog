<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UpdatePost extends Controller
{
    use ApiResponser;
    public function __construct()
    {
       // $this->middleware();
    }
    public function updateDetails(PostRequest $request , Post $post)
    {

        $post->update([
            'title' => $request->title,
            'content' => $request->conten,
        ]);

        return $this->successResponse($post , 202);
    }

    public function updatePhotos($request)
    {

    }

    public function updateCategory($request  , Post $post)
    {
        $categoryId = Category::where('name' , $request->category)->get()[0]->id;

        $category = $post->categories()->get();

        $category->update(['id' => $categoryId]);

        return $this->successResponse($post->with('categories')->get() , 202);
    }

    public function updateTag(PostRequest $request , Post $post)
    {
        $tagId = Category::where('name' , $request->category)->get()[0]->id;

        $tag = $post->categories()->get();

        $tag->update(['id' => $tagId]);

        return $this->successResponse($post->with('tags')->get() , 202);
    }

}

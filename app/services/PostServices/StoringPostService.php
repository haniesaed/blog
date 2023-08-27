<?php

namespace App\services\PostServices;

use App\Models\Admin;
use App\Models\Category;
use App\Models\PhotoPost;
use App\Models\Post;
use App\Models\Tag;
use App\Notifications\PostsNotifications;
use App\Traits\ApiResponser;
use Exception;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StoringPostService
{
    use ApiResponser;

    function store($request)
    {
        try {
            DB::beginTransaction();
            $post = $this->storePost($request);

            if ( $request->hasFile('photos') ) {
                $this->storePostPhotos($request , $post->id);
            }

            DB::commit();
            $admins = Admin::all();
            Notification::send($admins , new PostsNotifications($post , $post->author));
            return $this->successResponse($post , 201);

        }catch (Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage() , 400);
        }

    }

    function storePost($request)
    {

        try {
            DB::beginTransaction();

            $categoryId = Category::where('name' , $request->category)->firstOrFail()->id;

            $tagId = Tag::where('name' , $request->tag)->firstOrFail()->id;


            $post = Post::create([
                'author_id' => auth()->guard('author')->id(),
                'title' => $request->title,
                'content' => $request->content,
            ]);

            $post->categories()->attach([$categoryId]);
            $post->tags()->attach([$tagId]);

            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return $this->errorResponse($e->getMessage() , 400);
        }
        return $post;
    }

    function storePostPhotos($request , $postId) :void
    {

//       $photo = $request->file('photos');
       //dd($photos->store('posts'));

            $filename = time() . '.' . $request->photos->extension();

             $request->photos->move(public_path('photos'), $filename);
      //  dd($postPhotos);
       // $postId = DB::table('posts')->where('id' , $postId)->get()->id;
            $postPhotos = PhotoPost::create([
                "post_id" => $postId,
                "photos" => $filename
            ]);



    }


}

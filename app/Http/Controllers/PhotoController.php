<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use App\Models\PhotoPost;
use App\services\PostServices\StoringPostService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    use ApiResponser;
    public function store(PhotoRequest $request)
    {

        (new StoringPostService())->storePostPhotos($request , $request->post_id);

        return $this->successResponse(["message" => "the photo has been stored"]);
    }
}

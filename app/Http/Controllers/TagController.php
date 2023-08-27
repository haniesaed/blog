<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\tag;
use App\Traits\ApiResponser;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    use ApiResponseHelpers;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithSuccess(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(tagRequest $request)
    {

        $tag = Tag::create([
            'name' => $request->name
        ]);

        return $this->respondCreated($tag);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::where("id" , $id)->get();
        return  $this->respondWithSuccess($tag);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(tagRequest $request, string $id)
    {
        $tag = Tag::find($id);
        $tag->update($request->all());

        return $this->respondOk("tag has been Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);
        $tag->delete();

        return $this->respondOk("tag has been deleted");

    }
}

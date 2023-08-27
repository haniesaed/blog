<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Traits\ApiResponser;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    use ApiResponseHelpers , ApiResponser;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->respondWithSuccess(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {

       $category = Category::create([
           'name' => $request->name
        ]);

        return $this->respondCreated($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::where("id" , $id)->get();
       return  $this->respondWithSuccess($category);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $category = Category::find($id);
        $category->update($request->all());

        return $this->respondOk("Category has been Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        return $this->respondOk("Category has been deleted");
    }
}

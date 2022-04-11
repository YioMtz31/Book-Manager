<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

      /**
     * Get all categories
     */
    public function index()
    {
        $categories = Category::all();
        return new CategoryCollection($categories);
    }

  /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
    $data = request()->validate([
        'name' => 'required',
        'description' => 'required'
    ]);

      $category = Category::create($data);
      return new CategoryResource($category);
   }

    /**
     * update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        $data = request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $category->update($data);
        return new CategoryResource($category);
    }

     /**
     * delete a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $response = $category->delete();
        return $response;
    }
}

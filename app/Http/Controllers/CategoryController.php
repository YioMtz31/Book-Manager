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
    public function index(Request $request)
    {
        $columns = ['id','name','description'];
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = Category::select('id','name','description')->orderBy($columns[$column],$dir);

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }
        $categories = $query->paginate($request->length);
        return new CategoryCollection($categories);
    }



    /**
     * categories list for select box
     */
    public function show(Request $request)
    {
        $searchValue = $request->search;
        $query = Category::select('id','name');

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }
        $categories = $query->get();
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
        'name' => 'unique:App\Models\Category,name',
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

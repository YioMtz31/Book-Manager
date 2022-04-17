<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    /**
     * Get all authors
     */
    public function index(Request $request)
    {
        $columns = ['id','name'];
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = Author::select('id','name')->orderBy($columns[$column],$dir);

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }
        $authors = $query->paginate($request->length);
        return new AuthorCollection($authors);
    }

    /**
     * authors list for select box
     */
    public function show(Request $request)
    {
        $searchValue = $request->search;
        $query = Author::select('id','name');

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }
        $authors = $query->get();
        return new AuthorCollection($authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'name' => 'unique:App\Models\Author,name'
        ]);

        $author = Author::create($data);
        return new AuthorResource($author);
    }

    /**
     * update a resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Author $author)
    {
        $data = request()->validate([
            'name' => 'required'
        ]);

        $author->update($data);
        return new AuthorResource($author);
    }
}

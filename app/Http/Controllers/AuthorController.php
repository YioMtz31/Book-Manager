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
    public function index()
    {
        $authors = Author::all();
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
            'name' => 'required'
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

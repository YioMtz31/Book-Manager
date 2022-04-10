<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author = new Author;
        $author->name = $request->name;
        $author->save();
        return new AuthorResource($author);
    }
}

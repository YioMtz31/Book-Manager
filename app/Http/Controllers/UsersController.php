<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UsersCollection;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return new UsersCollection($users);
    }


        /**
     * Users list for select box
     */
    public function show(Request $request)
    {
        $searchValue = $request->search;
        $query = User::select('id','name');

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }
        $categories = $query->get();
        return new UsersCollection($categories);
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
            'name' => 'required'
        ]);

        $user = User::create($data);
        return new UsersResource($user);
    }

}

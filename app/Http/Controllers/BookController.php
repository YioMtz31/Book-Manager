<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\http\Resources\BookResource;
use App\http\Resources\BooksCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['id','name','author_id','category_id','publication_date','user_id'];
        $column = $request->column;
        $categoryFilter = $request->categoryFilter;
        $authorFilter = $request->authorFilter;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = Book::select('id','name','author_id','category_id','user_id','publication_date')->orderBy($columns[$column],$dir);

        if($categoryFilter){
            $query->where(function($query) use ($categoryFilter){
                $query->where('category_id',$categoryFilter);
            });
        }

        if($authorFilter){
            $query->where(function($query) use ($authorFilter){
                $query->where('author_id',$authorFilter);
            });
        }

        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
            $query->orWhere(function($query) use ($searchValue){
                $query->where('publication_date','like','%'.$searchValue.'%');
            });
            $query->orWhereHas('category', function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
            $query->orWhereHas('author', function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
            $query->orWhereHas('user', function($query) use ($searchValue){
                $query->where('name','like','%'.$searchValue.'%');
            });
        }

        $books = $query->paginate($request->length);
        return new BooksCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if(!$user->is_admin){
            return false;
        }
        $data = request()->validate([
            'name' => 'required|unique:App\Models\Book,name',
            'author_id' => 'required',
            'category_id' => 'required',
            'publication_date' => 'required',
            'user_id' =>''
        ]);

        $book = Book::create($data);
        return new BookResource($book);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Book $book)
    {
        $user = auth()->user();
        if($user->is_admin){
            $data = request()->validate([
                'name' => 'required',
                'author_id' => 'required',
                'category_id' => 'required',
                'publication_date' => 'required',
                'user_id' =>''
            ]);
            $book->update($data);
        }else{
            $data = request()->validate([
                'user_id' =>'required|integer'
            ]);

            $book->update($data);
        }



        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        if(!$user->is_admin){
            return false;
        }
        $id = intval($id);
        $book = Book::find($id);
        return $response = $book->delete();
    }
}

<?php

namespace App\Http\Controllers;
use App\Http\Models\User;
use App\Http\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $books = auth()->user()->books;
 
        return response()->json([
            'success' => true,
            'data' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'author'=> 'required',
            'date_published' => 'required'
        ]);
 
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->date_published = $request->date_published;
        $book->overview = $request->overview;
        $book->isbn = $request->isbn;
 
        if (auth()->user()->books()->save($book))
            return response()->json([
                'success' => true,
                'data' => $book->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'book not added'
            ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = auth()->user()->books()->find($id);
 
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $book->toArray()
        ], 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'author'=> 'required',
            'date_published' => 'required'
        ]);

        $book = auth()->user()->books()->find($id);
 
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found'
            ], 400);
        }
 
        $book->title = $request->title;
        $book->author = $request->author;
        $book->date_published = $request->date_published;
        $book->overview = $request->overview;
        $book->isbn = $request->isbn;

 
        if (auth()->user()->books()->save($book))
            return response()->json([
                'success' => true,
                'data' => $book->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'book not added'
            ], 500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $book = auth()->user()->books()->find($id);
 
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'book not found'
            ], 400);
        }
 
        if ($book->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'book can not be deleted'
            ], 500);
        }
    
    }
}

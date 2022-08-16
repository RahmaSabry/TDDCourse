<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store(BookStoreRequest $request)
    {
        Book::create([
            "title" => request('title'),
            "description" => request('description'),
            "author_id" => request('author_id'),
            "ISBN" => request('ISBN'),
        ]);
        return response(['message'=> "created"], 201);
    }

    public function create()
    {
        return view('books-form');
    }
    public function index()
    {
        return response()->json(['books'=> BookResource::collection(Book::all())]);
    }
}

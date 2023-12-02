<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\Book as BookResource;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Retrieves and returns a collection of book resources.
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * Creates a new book and returns the resource of the created book.
     */
    public function store(StoreBookRequest $request)
    {
        return new BookResource(Book::create(
            $request->only(['title', 'author', 'published_at'])
        ));
    }

    /**
     * Retrieves and returns the resource of a specific book.
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Updates the book data and returns the resource of the updated book.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->only(['title', 'author', 'published_at']));
        return new BookResource($book);
    }

    /**
     * Deletes the specified book and returns a response with no content.
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id);
        return response()->noContent();
    }
}

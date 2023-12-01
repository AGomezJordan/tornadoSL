<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\Chapter as ChapterResource;
use App\Models\Book;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Book $book)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChapterRequest $request, Book $book)
    {
        $chapter = new Chapter($request->only(['number_chapter', 'title', 'summary']));
        $book->chapters()->save($chapter);

        return new ChapterResource($chapter);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book, Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChapterRequest $request, Book $book, Chapter $chapter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, Chapter $chapter)
    {
        //
    }
}

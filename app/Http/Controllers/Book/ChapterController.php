<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Chapter as ChapterResource;
use App\Models\Book;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * Displays a list of chapters associated with a specific book resource.
     */
    public function index(Book $book)
    {
        $book->load(['chapters']);
        return new BookResource($book);
    }

    /**
     * Stores a newly created chapter in the database related to a book.
     */
    public function store(StoreChapterRequest $request, Book $book)
    {
        $chapter = new Chapter($request->only(['number_chapter', 'title', 'summary']));
        $book->chapters()->save($chapter);

        return new ChapterResource($chapter);
    }

    /**
     * Displays details of a specific chapter linked to a particular book.
     */
    public function show(Book $book, Chapter $chapter)
    {
        $book->chapters()->findOrFail($chapter->id);
        return new ChapterResource($chapter);
    }

    /**
     * Updates the details of a specific chapter related to a book in the database.
     */
    public function update(UpdateChapterRequest $request, Book $book, Chapter $chapter)
    {
        $chapterEdited = $book->chapters()->findOrFail($chapter->id);
        $chapterEdited->update($request->only(['number_chapter', 'title', 'summary']));
        return new ChapterResource($chapterEdited);
    }

    /**
     * Deletes a specific chapter associated with a book from the database.
     */
    public function destroy(Book $book, Chapter $chapter)
    {
        Chapter::destroy($book->chapters()->findOrFail($chapter->id)->id);
        return response()->noContent();
    }
}

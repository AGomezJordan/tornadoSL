<?php
use App\Http\Controllers\BookController;
use App\Http\Controllers\Book\ChapterController as BookChapterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::apiResource('books', BookController::class);
Route::apiResource('books.chapters', BookChapterController::class);
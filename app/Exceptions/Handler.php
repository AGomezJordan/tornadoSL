<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ParseError;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {

        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $exception)
    {
        if (str_starts_with($request->server("REQUEST_URI"), '/api')) {
            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
            } elseif ($exception instanceof QueryException || $exception instanceof ParseError) {
                $statusCode = 500;
            } elseif ($exception instanceof ModelNotFoundException) {
                $statusCode = 404;
            } else {
                $statusCode = 400;
            }
            return response()->json(['error' => $exception->getMessage()], $statusCode);
        }

        return parent::render($request, $exception);
    }

}

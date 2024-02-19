<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
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
            //
        });
    }
//    public function render($request, Throwable $exception)
//    {
//        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
//            return response()->json(['error' => 'Not Found'], Response::HTTP_NOT_FOUND);
//        }
//
//        if ($this->isHttpException($exception)) {
//            $statusCode = $exception->getStatusCode();
//
//            switch ($statusCode) {
//                case 404:
//                    return response()->view('errors.404', [], $statusCode);
//                case 500:
//                    return response()->view('errors.500', [], $statusCode);
//                case 403:
//                    return response()->view('errors.403Error', [], $statusCode);
//                case 401:
//                    return response()->view('errors.401', [], $statusCode);
//            }
//        }
//
//        return parent::render($request, $exception);
//    }
}

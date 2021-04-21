<?php

namespace App\Support\Core\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * {@inheritDoc}
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['message' => 'Not found.'], 404);
        }
        if ($request->expectsJson()) {
            $data = [];
            $data['message'] = $exception->getMessage();
            $statusCode = 500;
            if ($exception instanceof PostTooLargeException) {
                $statusCode = 400;
            }
            if ($exception instanceof AuthenticationException) {
                $data['message'] = 'Unauthorized.';
                $statusCode = 401;
            }
            if ($exception instanceof ThrottleRequestsException) {
                $statusCode = 429;
            }
            if ($exception instanceof ModelNotFoundException) {
                $statusCode = 404;
            }
            if ($exception instanceof ValidationException) {
                $statusCode = 422;
                $data['errors'] = $exception->errors();
            }
            return response()->json($data, $statusCode);
        }

        return parent::render($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}

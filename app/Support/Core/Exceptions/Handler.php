<?php

namespace App\Support\Core\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
        if ($exception instanceof PostTooLargeException) {
            return $this->throws($exception, 413);
        }
        if ($exception instanceof AuthenticationException) {
            return $this->throws($exception, 401);
        }
        if ($exception instanceof ThrottleRequestsException) {
            return $this->throws($exception, 429);
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->throws($exception, 404);
        }
        if ($exception instanceof ValidationException) {
            return $this->throws($exception, 422);
        }

        return parent::render($request, $exception);
    }

    /**
     * Throws api exception
     *
     * @param Throwable $exception
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function throws(
        Throwable $exception,
        int $statusCode = 500
    ): JsonResponse {
        $data = [];
        $data['message'] = $exception->getMessage();
        if ($statusCode === 422) {
            /** @var ValidationException $exception */
            $data['errors'] = $exception->errors();
        }
        if (Config::get('app.debug') === true) {
            $data['trace'] = explode("\n", $exception->getTraceAsString());
        }

        return response()->json($data, $statusCode);
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

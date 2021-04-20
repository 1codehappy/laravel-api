<?php

namespace App\Support\Core\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
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
            return response()
                ->json([
                    'message' => 'Not found.',
                ],
                404
            );
        }

        $data = [];
        $data['message'] = $exception->getMessage();
        if (! in_array(Config::get('app.env'), ['prod', 'production'])) {
            $data['trace'] = explode("\n", $exception->getTraceAsString());
        }
        return response()
            ->json(
                $data,
                $exception->getCode() ?: 500
            )
        ;
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

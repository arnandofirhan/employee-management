<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->shouldReturnJson($request, $exception)
            ? response()->json([
                'meta'  => [
                    'success'   => false,
                    'code'      => 401,
                    'message'   => $exception->getMessage(),
                    'errors'    => [],
                ],
                'data'  => null
            ], 401)
            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'meta'  => [
                'success'   => false,
                'code'      => $exception->status,
                'message'   => $exception->getMessage(),
                'errors'    => $exception->errors(),
            ],
            'data'  => null
        ], $exception->status);
    }
}

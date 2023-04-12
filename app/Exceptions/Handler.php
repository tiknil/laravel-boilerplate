<?php

namespace App\Exceptions;

use App\Http\Responses\Api\ApiError;
use App\Http\Responses\Api\ErrorResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        $isApi = str_starts_with($request->path(), 'api/') || $request->wantsJson();

        if ($e instanceof NotFoundHttpException && $isApi) {
            return ErrorResponse::json(
                404,
                ApiError::HttpNotFound,
                'Invalid endpoint'
            );
        }

        if ($e instanceof ModelNotFoundException && $isApi) {
            return ErrorResponse::json(
                404,
                ApiError::ResourceNotFound,
                'Invalid requested resource'
            );
        }

        if ($e instanceof MethodNotAllowedHttpException && $isApi) {
            return ErrorResponse::json(
                405,
                ApiError::InvalidMethod,
                "Invalid method {$request->method()}"
            );
        }

        // Missing or wrong sanctum token
        if ($e instanceof AuthenticationException && $isApi) {
            return ErrorResponse::unauthorized();
        }

        // Wrong token type
        if ($e instanceof MissingAbilityException && $isApi) {
            return ErrorResponse::forbidden('Wrong token type');
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}

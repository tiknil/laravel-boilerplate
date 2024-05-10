<?php

use App\Http\Responses\Api\ApiError;
use App\Http\Responses\Api\ErrorResponse;
use App\Providers\AppServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Bugsnag\BugsnagLaravel\BugsnagServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->throttleApi();

        $middleware->alias([
            'abilities' => \Laravel\Sanctum\Http\Middleware\CheckAbilities::class,
            'ability' => \Laravel\Sanctum\Http\Middleware\CheckForAnyAbility::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        /*
         * Alcune eccezioni vengono generate direttamente da Laravel.
         * In caso di richieste API, usiamo la risposta di errore standard
         */

        // Errore 404
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ErrorResponse::json(
                    404,
                    ApiError::HttpNotFound,
                    'Invalid endpoint'
                );
            }
        });

        // Modello non trovato con ::findOrFail
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*')) {
                return ErrorResponse::json(
                    404,
                    ApiError::ResourceNotFound,
                    'Invalid requested resource'
                );
            }
        });

        // Errore 405
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return ErrorResponse::json(
                    405,
                    ApiError::InvalidMethod,
                    "Invalid method {$request->method()}"
                );
            }
        });

        // Unauthorized
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return ErrorResponse::unauthorized();
            }
        });

        // Sanctum wrong token
        $exceptions->render(function (MissingAbilityException $e, Request $request) {
            if ($request->is('api/*')) {
                return ErrorResponse::forbidden('Wrong token type');
            }
        });

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        });
    })->create();

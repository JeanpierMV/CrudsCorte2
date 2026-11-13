<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\ConnectionException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (QueryException|ConnectionException $exception, Request $request) {
            $message = 'No se pudo completar la solicitud por un problema con la base de datos. '
                .'La información existente se conserva. Si intentabas guardar un registro, verifica '
                .'si se creó antes de volver a intentarlo.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 503);
            }

            if ($request->hasSession()) {
                $session = $request->session();

                if ($session->has('_old_input')) {
                    $session->keep('_old_input');
                } elseif ($request->input() !== []) {
                    $session->flash('_old_input', $request->except([
                        '_token',
                        '_method',
                        'password',
                        'password_confirmation',
                    ]));
                }
            }

            return response()->view('errors.database', ['message' => $message], 503);
        });
    })->create();

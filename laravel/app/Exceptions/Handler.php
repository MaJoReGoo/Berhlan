<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    public function render($request, Throwable $exception)
    {

        $url = explode('/', url()->current());
        if (count($url) === 6 && $url[5] === 'error') {
            return parent::render($request, $exception);
        } else {
            if (url()->current() !== 'http://192.168.1.210/Berhlan/public'  ) {
                return parent::render($request, $exception);
            } else {
                return response()->view('includes-panel.Pagina-Mantenimiento');
            }
        }

    }
}

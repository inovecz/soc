<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ConnectionException) {
            $trace = $exception->getTrace();
            $service = null;
            foreach ($trace as $frame) {
                if (isset($frame['file']) && str_contains($frame['file'], '/Libraries/')) {
                    $service = pathinfo(basename($frame['file']), PATHINFO_FILENAME);
                    break;
                }
            }
            abort(503, 'Service unavailable'.($service ? ': '.$service : ''));
        }

        return parent::render($request, $exception);
    }
}

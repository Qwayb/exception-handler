<?php

namespace Qwayb\ExceptionHandler;

use Throwable;
use ErrorException;

class ExceptionHandler
{
    public static function register(): void
    {
        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleException(Throwable $e): void
    {
        $code = $e->getCode();
        $registered = ExceptionMessageRegistry::getMessage($code);

        $status = $registered['status'] ?? 500;
        $message = $registered['message'] ?? $e->getMessage();

        http_response_code($status);
        header('Content-Type: application/json');

        echo json_encode([
            'status'  => $status,
            'code'    => $code,
            'message' => $message
        ]);

        exit;
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            http_response_code(500);
            header('Content-Type: application/json');

            echo json_encode([
                'status'  => 500,
                'code'    => 0,
                'message' => 'Fatal error: ' . $error['message']
            ]);
        }
    }
}

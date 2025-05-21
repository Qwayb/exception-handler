<?php

namespace Qwayb\ExceptionHandler;

class ExceptionRegistry
{
    private static $customMessages = [];
    private static $debugMode = false;

    public static function setDebugMode(bool $debug): void
    {
        self::$debugMode = $debug;
    }

    public static function register(string $exceptionClass, string $message, string $code): void
    {
        self::$customMessages[$exceptionClass] = [
            'message' => $message,
            'code'    => $code
        ];
    }

    public static function resolve(\Throwable $e): array
    {
        $exceptionClass = get_class($e);

        $status = method_exists($e, 'getStatusCode')
            ? $e->getStatusCode()
            : 500;

        $message = self::$customMessages[$exceptionClass]['message'] ?? $e->getMessage();
        $code    = self::$customMessages[$exceptionClass]['code'] ?? 'UNKNOWN_ERROR';

        $error = [
            'status'    => $status,
            'code'      => $code,
            'message'   => $message,
            'exception' => $exceptionClass
        ];

        if (self::$debugMode) {
            $error['debug'] = [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTrace()
            ];
        }

        return $error;
    }
}

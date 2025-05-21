<?php

namespace Qwayb\ExceptionHandler;

class ExceptionRegistry
{
    private static $exceptions = [];

    public static function register(string $exceptionClass, array $config): void
    {
        self::$exceptions[$exceptionClass] = [
            'status' => $config['status'] ?? 500,
            'message' => $config['message'] ?? 'Internal Server Error',
            'code' => $config['code'] ?? 'GENERIC_ERROR'
        ];
    }

    public static function resolve(\Throwable $e): array
    {
        $exceptionClass = get_class($e);

        foreach (self::$exceptions as $class => $config) {
            if ($e instanceof $class) {
                return [
                    'status' => $config['status'],
                    'message' => str_replace(
                        '{original_message}',
                        $e->getMessage(),
                        $config['message']
                    ),
                    'code' => $config['code']
                ];
            }
        }

        return [
            'status' => 500,
            'message' => $e->getMessage(),
            'code' => 'UNHANDLED_ERROR'
        ];
    }
}
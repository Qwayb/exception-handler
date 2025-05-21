<?php

namespace Qwayb\ExceptionHandler;

class ExceptionHandler
{
    public static function handle(callable $callback): array
    {
        try {
            return [
                'success' => true,
                'data' => $callback()
            ];
        } catch (\Throwable $e) {
            $error = ExceptionRegistry::resolve($e);
            return [
                'success' => false,
                'error' => $error
            ];
        }
    }
}
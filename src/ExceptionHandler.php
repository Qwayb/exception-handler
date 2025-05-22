<?php

namespace Qwayb\ExceptionHandler;

use ExceptionRegistry;

class ExceptionHandler
{
    public static function handle(callable $callback): array
    {
        try {
            return ['success' => true, 'data' => $callback()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => ExceptionRegistry::resolve($e)];
        }
    }
}
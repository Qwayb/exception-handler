<?php

namespace Qwayb\ExceptionHandler;

class ExceptionHandler
{
    public static function handle(callable $callback): array
    {
        try {
            return ['data' => $callback()];
        } catch (\Throwable $e) {
            return ['error' => ExceptionRegistry::resolve($e)];
        }
    }
}
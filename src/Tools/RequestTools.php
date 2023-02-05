<?php

namespace src\Tools;

use src\Enums\RequestEnum;

class RequestTools
{
    public static function inputServer(string $key): mixed
    {
        return $_SERVER[$key] ?? null;
    }

    /**
     * @return object|null
     * @codeCoverageIgnore
     */
    public static function inputPhpInput(): ?object
    {
        return json_decode(file_get_contents('php://input')) ?? null;
    }

    public static function isPostRequest(): bool
    {
        if (self::inputServer(RequestEnum::REQUEST_METHOD) == RequestEnum::POST) {
            return true;
        }
        return false;
    }
}
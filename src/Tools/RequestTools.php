<?php

namespace src\Tools;

class RequestTools
{
    public static function inputServer(string $key): mixed
    {
        return $_SERVER[$key] ?? null;
    }

    public static function inputPhpInput(): ?object
    {
        return json_decode(file_get_contents('php://input')) ?? null;
    }
}
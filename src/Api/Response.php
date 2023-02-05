<?php

namespace src\Api;

use src\Enums\HttpStatusCode;

class Response
{
    public static function render(int $code, mixed $print): void
    {
        http_response_code($code);
        exit(json_encode($print));
    }

    public static function renderMethodNotAllowed(): void
    {
        self::render(
            HttpStatusCode::METHOD_NOT_ALLOWED,
            'Método não aceito, revise a documentação!'
        );
    }

    public static function renderNotFound(): void
    {
        self::render(
            HttpStatusCode::NOT_FOUND,
            'Não encontrado!'
        );
    }
}
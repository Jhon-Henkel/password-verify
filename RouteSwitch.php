<?php

use src\Enums\HttpStatusCode;
use src\Tools\RequestTools;

abstract class RouteSwitch
{
    protected function verify(): void
    {
        d(RequestTools::inputPhpInput());
        die('caiu dentro do verify');
    }

    public function __call($name, $arguments): void
    {
        http_response_code(HttpStatusCode::NOT_FOUND);
        exit(json_encode('Not found'));
    }
}
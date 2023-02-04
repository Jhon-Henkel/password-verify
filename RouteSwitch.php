<?php

namespace RouteSwitch;

use src\Enums\HttpStatusCode;
use src\Tools\RequestTools;

abstract class RouteSwitch
{
    protected function verify(): void
    {
        d(RequestTools::inputPhpInput());
        die();
    }

    public function __call($name, $arguments): void
    {
        http_response_code(HttpStatusCode::NOT_FOUND);
        exit('Not found');
    }
}
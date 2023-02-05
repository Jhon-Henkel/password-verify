<?php

use src\Tools\RequestTools;
use src\Controller\PasswordVerifyController;
use src\Api\Response;

abstract class RouteSwitch
{
    protected function verify(): void
    {
        if (!RequestTools::isPostRequest()) {
            Response::renderMethodNotAllowed();
        }
        $controller = new PasswordVerifyController();
        $controller->verifyPassword(RequestTools::inputPhpInput());
        unset($controller);
    }

    public function __call($name, $arguments): void
    {
        Response::renderNotFound();
    }
}
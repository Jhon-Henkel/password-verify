<?php

use RouteSwitch\RouteSwitch;

class Router extends RouteSwitch
{
    public function run(string $requestUri)
    {
        $route = substr($requestUri, 1);
        $this->$route();
    }
}
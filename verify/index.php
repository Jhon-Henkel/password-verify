<?php

require_once __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/../index.php';

d(\src\Tools\RequestTools::inputPhpInput());
d($_POST);
d($_GET);
d(file_get_contents('php://input'));
d(\src\Tools\RequestTools::inputServer('REQUEST_METHOD'));
die();
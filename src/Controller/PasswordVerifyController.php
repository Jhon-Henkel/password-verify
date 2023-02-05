<?php

namespace src\Controller;

use src\Api\Response;
use src\BO\PasswordVerifyBO;
use src\Exceptions\AttributeMissingException;
use src\Exceptions\InvalidTypeException;
use stdClass;

class PasswordVerifyController
{
    private PasswordVerifyBO $bo;

    public function __construct()
    {
        $this->bo = new PasswordVerifyBO();
    }

    public function verifyPassword(stdClass $object)
    {
        try {
            $this->bo->validatePostObject($object);
            d($object);
            die();
        } catch (InvalidTypeException|AttributeMissingException $exception) {
            Response::renderBadRequest($exception->getMessage());
        }
    }
}
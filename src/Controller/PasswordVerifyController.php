<?php

namespace src\Controller;

use src\API\Response;
use src\BO\PasswordVerifyBO;
use src\Enums\HttpStatusCode;
use src\Exceptions\AttributeMissingException;
use src\Exceptions\InvalidRuleException;
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
            $verify = $this->bo->verify($object);
            $return = $this->bo->populateReturn($verify);
            Response::render(HttpStatusCode::OK, $return);
        } catch (
            InvalidTypeException
            |AttributeMissingException
            |InvalidRuleException
            $exception
        ) {
            Response::renderBadRequest($exception->getMessage());
        }
    }
}
<?php

namespace src\BO;

use src\Enums\AttributeEnum;
use src\Enums\RulesEnum;
use src\Enums\TypeEnum;
use src\Exceptions\AttributeMissingException;
use src\Exceptions\InvalidRuleException;
use src\Exceptions\InvalidTypeException;
use src\Tools\MessagesTools;
use stdClass;

class PasswordVerifyBO
{
    public function validatePostObject(stdClass $object): bool
    {
        if (!isset($object->password)) {
            $message = MessagesTools::attributeMissing(AttributeEnum::PASSWORD);
            throw new AttributeMissingException($message);
        }
        if (!isset($object->rules)) {
            $message = MessagesTools::attributeMissing(AttributeEnum::RULES);
            throw new AttributeMissingException($message);
        }
        if (!is_string($object->password)) {
            $message = MessagesTools::invalidAttributeType(AttributeEnum::PASSWORD, TypeEnum::STRING);
            throw new InvalidTypeException($message);
        }
        if (!is_array($object->rules)) {
            $message = MessagesTools::invalidAttributeType(AttributeEnum::RULES, TypeEnum::ARRAY);
            throw new InvalidTypeException($message);
        }
        $this->validateRulesPost($object->rules);
        return true;
    }

    protected function validateRulesPost(array $rules): bool
    {
        foreach ($rules as $rule) {
            if (!is_object($rule)) {
                $message = MessagesTools::invalidAttributeContentType(AttributeEnum::RULES, TypeEnum::OBJECT);
                throw new InvalidTypeException($message);
            }
            if (!isset($rule->rule)) {
                $message = MessagesTools::attributeMissing(AttributeEnum::RULE);
                throw new AttributeMissingException($message);
            }
            if (!isset($rule->value)) {
                $message = MessagesTools::attributeMissing(AttributeEnum::VALUE);
                throw new AttributeMissingException($message);
            }
            if (!is_string($rule->rule)) {
                $message = MessagesTools::invalidAttributeType(AttributeEnum::RULE, TypeEnum::STRING);
                throw new InvalidTypeException($message);
            }
            if (!in_array($rule->rule, RulesEnum::getRulesArray())) {
                $message = MessagesTools::invalidRule($rule->rule);
                throw new InvalidRuleException($message);
            }
            if (!is_integer($rule->value)) {
                $message = MessagesTools::invalidAttributeType(AttributeEnum::VALUE, TypeEnum::INT);
                throw new InvalidTypeException($message);
            }
        }
        return true;
    }
}
<?php

namespace src\Tools;

use src\Enums\RulesEnum;

class MessagesTools
{
    public static function invalidAttributeType(string $attribute, string $type): string
    {
        return 'O atributo "' . $attribute . '" deve ser do tipo '. $type . '!';
    }

    public static function invalidAttributeContentType(string $attribute, string $type): string
    {
        return 'O conteúdo de "' . $attribute . '" deve ser do tipo '. $type . '!';
    }

    public static function attributeMissing(string $attribute): string
    {
        return 'Atributo obrigatório ausente: ' . $attribute;
    }

    public static function invalidRule(string $rule): string
    {
        $rules = implode(', ', RulesEnum::getRulesArray());
        return 'Regra inválida: ' . $rule . ', as regras válidas são: ' . $rules;
    }
}
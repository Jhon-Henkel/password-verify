<?php

namespace src\Enums;

class RulesEnum
{
    const MIN_SIZE = 'minSize';
    const MIN_UPPERCASE = 'minUppercase';
    const MIN_LOWERCASE = 'minLowercase';
    const MIN_DIGIT = 'minDigit';
    const MIN_SPECIAL_CHARS = 'minSpecialChars';
    const NO_REPEATED = 'noRepeated';

    public static function getRulesArray(): array
    {
        return array(
            self::MIN_DIGIT,
            self::MIN_LOWERCASE,
            self::MIN_SIZE,
            self::MIN_SPECIAL_CHARS,
            self::MIN_UPPERCASE,
            self::NO_REPEATED
        );
    }
}
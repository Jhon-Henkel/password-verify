<?php

namespace src\BO;

class RuleBO
{
    public function minSize(string $password, int $value): bool
    {
        return strlen($password) >= $value;
    }

    public function minUppercase(string $password, int $value): bool
    {
        $upperChars = preg_match_all("/[A-Z]/", $password);
        return $upperChars >= $value;
    }

    public function minLowercase(string $password, int $value): bool
    {
        $lowerChars = preg_match_all("/[a-z]/", $password);
        return $lowerChars >= $value;
    }

    public function minDigit(string $password, int $value): bool
    {
        $digitChars = preg_match_all("/[0-9]/", $password);
        return $digitChars >= $value;
    }

    public function minSpecialChars(string $password, int $value): bool
    {
        $specialChars = '"%!%¨¬@$\'-+_*;<>?^§ªº~£¢¹²³^:.,´`{|}~/\\#=&[]()';
        $pattern = preg_quote($specialChars, '/');
        $digitChars = preg_match_all('/[' . $pattern . ']/', $password);
        return $digitChars >= $value;
    }

    public function noRepeated(string $password): bool
    {
        $arrayChars = str_split($password);
        for ($index = 0; $index < count($arrayChars); $index ++) {
            if ($index == count($arrayChars) - 1) {
                break;
            }
            $atualChar = $arrayChars[$index];
            $nextChar = $arrayChars[$index + 1];
            if ($atualChar == $nextChar) {
                return false;
            }
        }
        return true;
    }
}
<?php

namespace tests\Unit\Tools;

use PHPUnit\Framework\TestCase;
use src\Tools\MessagesTools;

class MessageToolsUnitTest extends TestCase
{
    public function testInvalidAttributeType()
    {
        $message = MessagesTools::invalidAttributeType('aaa', 'bbb');
        $expect = 'O atributo "aaa" deve ser do tipo bbb!';
        $this->assertEquals($expect, $message);
    }

    public function testInvalidAttributeContentType()
    {
        $message = MessagesTools::invalidAttributeContentType('aaa', 'bbb');
        $expect = 'O conteúdo de "aaa" deve ser do tipo bbb!';
        $this->assertEquals($expect, $message);
    }

    public function testAttributeMissing()
    {
        $message = MessagesTools::attributeMissing('aaa');
        $expect = 'Atributo obrigatório ausente: aaa';
        $this->assertEquals($expect, $message);
    }

    public function testInvalidRule()
    {
        $message = MessagesTools::invalidRule('aaa');
        $expect = 'Regra inválida: aaa, consulte a documentação!';
        $this->assertEquals($expect, $message);
    }
}
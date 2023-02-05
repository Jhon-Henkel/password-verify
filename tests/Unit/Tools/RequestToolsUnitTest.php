<?php

namespace tests\Unit\Tools;

use PHPUnit\Framework\TestCase;
use src\Enums\RequestEnum;
use src\Tools\RequestTools;

class RequestToolsUnitTest extends TestCase
{
    public function testInputServer()
    {
        $_SERVER['aaa'] = 'bbb';

        $this->assertEquals('bbb', RequestTools::inputServer('aaa'));
    }

    public function testIsPostRequestWithValidRequest()
    {
        $_SERVER[RequestEnum::REQUEST_METHOD] = RequestEnum::POST;
        $valid = RequestTools::isPostRequest();

        $this->assertTrue($valid);
    }

    public function testIsPostRequestWithInvalidRequest()
    {
        $_SERVER[RequestEnum::REQUEST_METHOD] = 'GET';
        $valid = RequestTools::isPostRequest();

        $this->assertFalse($valid);
    }
}
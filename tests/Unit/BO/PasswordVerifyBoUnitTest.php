<?php

namespace tests\Unit\BO;

use Mockery;
use PHPUnit\Framework\TestCase;
use src\BO\PasswordVerifyBO;
use src\Enums\RulesEnum;
use src\Exceptions\AttributeMissingException;
use src\Exceptions\InvalidRuleException;
use src\Exceptions\InvalidTypeException;
use stdClass;

class PasswordVerifyBoUnitTest extends TestCase
{
    private stdClass $object;
    private $passwordVerifyBoMock;
    
    protected function setUp(): void
    {
        $this->object = $this->makeTestObject();
        $this->passwordVerifyBoMock = $this->mockPasswordVerifyBo();
    }

    private function makeTestObject(): stdClass
    {
        $rule = new stdClass();
        $rule->rule = RulesEnum::NO_REPEATED;
        $rule->value = 2;

        $object = new stdClass();
        $object->password = 'test123';
        $object->rules = array($rule);

        return $object;
    }

    private function mockPasswordVerifyBo()
    {
        $passwordVerifyBoMock = Mockery::mock(PasswordVerifyBO::class)->makePartial();
        $passwordVerifyBoMock->shouldAllowMockingProtectedMethods();
        return $passwordVerifyBoMock;
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testValidatePostObjectWithInvalidPasswordType()
    {
        $this->passwordVerifyBoMock->shouldReceive('validateRulesPost')->never();
        $this->object->password = 1;

        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('O atributo "password" deve ser do tipo string!');

        $this->passwordVerifyBoMock->validatePostObject($this->object);
    }

    public function testValidatePostObjectWithoutPasswordParam()
    {
        $this->passwordVerifyBoMock->shouldReceive('validateRulesPost')->never();
        unset($this->object->password);

        $this->expectException(AttributeMissingException::class);
        $this->expectExceptionMessage('Atributo obrigatório ausente: password');

        $this->passwordVerifyBoMock->validatePostObject($this->object);
    }

    public function testValidatePostObjectWithoutRulesArray()
    {
        $this->passwordVerifyBoMock->shouldReceive('validateRulesPost')->never();
        unset($this->object->rules);

        $this->expectException(AttributeMissingException::class);
        $this->expectExceptionMessage('Atributo obrigatório ausente: rules');

        $this->passwordVerifyBoMock->validatePostObject($this->object);
    }

    public function testValidatePostObjectWithInvalidRulesParam()
    {
        $this->passwordVerifyBoMock->shouldReceive('validateRulesPost')->never();
        $this->object->rules = '123';

        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('O atributo "rules" deve ser do tipo array!');

        $this->passwordVerifyBoMock->validatePostObject($this->object);
    }

    public function testValidatePostObjectWithValidParams()
    {
        $this->passwordVerifyBoMock->shouldReceive('validateRulesPost')->once()->andReturnTrue();

        $this->assertTrue($this->passwordVerifyBoMock->validatePostObject($this->object));
    }

    public function testValidateRulesPostWithInvalidRulesType()
    {
        $this->object->rules = array(array('111' => '222'));

        $this->expectExceptionMessage(InvalidTypeException::class);
        $this->expectExceptionMessage('O conteúdo de "rules" deve ser do tipo object!');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithoutRuleParam()
    {
        unset($this->object->rules[0]->rule);

        $this->expectExceptionMessage(AttributeMissingException::class);
        $this->expectExceptionMessage('Atributo obrigatório ausente: rule');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithoutValueParam()
    {
        unset($this->object->rules[0]->value);

        $this->expectExceptionMessage(AttributeMissingException::class);
        $this->expectExceptionMessage('Atributo obrigatório ausente: value');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithInvalidRuleType()
    {
        $this->object->rules[0]->rule = 111;

        $this->expectExceptionMessage(InvalidTypeException::class);
        $this->expectExceptionMessage('O atributo "rule" deve ser do tipo string!');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithInvalidValueType()
    {
        $this->object->rules[0]->value = 'aaa';

        $this->expectExceptionMessage(InvalidTypeException::class);
        $this->expectExceptionMessage('O atributo "value" deve ser do tipo int!');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithInvalidRule()
    {
        $this->object->rules[0]->rule = 'aaa';

        $this->expectExceptionMessage(InvalidRuleException::class);
        $this->expectExceptionMessage('Regra inválida: aaa, consulte a documentação!');

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithValidRule()
    {
        $this->assertTrue($this->passwordVerifyBoMock->validateRulesPost($this->object->rules));
    }
}
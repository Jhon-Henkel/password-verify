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
    private array $rulesResults;
    
    protected function setUp(): void
    {
        $this->object = $this->makeTestObject();
        $this->passwordVerifyBoMock = $this->mockPasswordVerifyBo();
        $this->rulesResults = $this->makeRuleResults();
    }

    private function makeTestObject(): stdClass
    {
        $object = new stdClass();
        $object->password = 'test123';
        $object->rules = array(
            json_decode('{"rule": "minSize", "value": 2}'),
            json_decode('{"rule": "minUppercase", "value": 1}'),
            json_decode('{"rule": "minDigit", "value": 3}')
        );
        return $object;
    }

    private function mockPasswordVerifyBo()
    {
        $passwordVerifyBoMock = Mockery::mock(PasswordVerifyBO::class)->makePartial();
        $passwordVerifyBoMock->shouldAllowMockingProtectedMethods();
        return $passwordVerifyBoMock;
    }

    private function makeRuleResults(): array
    {
        return array(
            'minSize' => true,
            'minUppercase' => true,
            'minDigit' => true
        );
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
        $expectMessage = 'Regra inválida: aaa, as regras válidas são: minDigit, ';
        $expectMessage .= 'minLowercase, minSize, minSpecialChars, minUppercase, noRepeated';

        $this->expectExceptionMessage(InvalidRuleException::class);
        $this->expectExceptionMessage($expectMessage);

        $this->passwordVerifyBoMock->validateRulesPost($this->object->rules);
    }

    public function testValidateRulesPostWithValidRule()
    {
        $this->assertTrue($this->passwordVerifyBoMock->validateRulesPost($this->object->rules));
    }

    public function testVerifyWithRulesReturnTrue()
    {
        $this->object->password = 'Teste123';
        $verify = $this->passwordVerifyBoMock->verify($this->object);

        $this->assertIsArray($verify);
        $this->assertCount(3, $verify);
        $this->assertTrue($verify[RulesEnum::MIN_SIZE]);
        $this->assertTrue($verify[RulesEnum::MIN_UPPERCASE]);
        $this->assertTrue($verify[RulesEnum::MIN_DIGIT]);
    }

    public function testVerifyWithOneRuleBroken()
    {
        $this->object->password = 'Teste';
        $verify = $this->passwordVerifyBoMock->verify($this->object);

        $this->assertIsArray($verify);
        $this->assertCount(3, $verify);
        $this->assertTrue($verify[RulesEnum::MIN_SIZE]);
        $this->assertTrue($verify[RulesEnum::MIN_UPPERCASE]);
        $this->assertFalse($verify[RulesEnum::MIN_DIGIT]);
    }

    public function testVerifyWithThreeRulesBroken()
    {
        $this->object->password = 'q';
        $verify = $this->passwordVerifyBoMock->verify($this->object);

        $this->assertIsArray($verify);
        $this->assertCount(3, $verify);
        $this->assertFalse($verify[RulesEnum::MIN_SIZE]);
        $this->assertFalse($verify[RulesEnum::MIN_UPPERCASE]);
        $this->assertFalse($verify[RulesEnum::MIN_DIGIT]);
    }

    public function testPopulateReturnWithOneRuleBroken()
    {
        $this->rulesResults[RulesEnum::MIN_UPPERCASE] = false;
        $return = $this->passwordVerifyBoMock->populateReturn($this->rulesResults);

        $this->assertIsArray($return);
        $this->assertCount(2, $return);
        $this->assertFalse($return['verify']);
        $this->assertEquals(array(RulesEnum::MIN_UPPERCASE), $return['noMatch']);
    }

    public function testPopulateReturnWithThreeRulesBroken()
    {
        $this->rulesResults[RulesEnum::MIN_UPPERCASE] = false;
        $this->rulesResults[RulesEnum::MIN_DIGIT] = false;
        $return = $this->passwordVerifyBoMock->populateReturn($this->rulesResults);

        $this->assertIsArray($return);
        $this->assertCount(2, $return);
        $this->assertFalse($return['verify']);
        $this->assertEquals(array("minUppercase, minDigit"), $return['noMatch']);
    }

    public function testPopulateReturnWithNoRulesBroken()
    {
        $return = $this->passwordVerifyBoMock->populateReturn($this->rulesResults);

        $this->assertIsArray($return);
        $this->assertCount(2, $return);
        $this->assertTrue($return['verify']);
        $this->assertEquals(array(), $return['noMatch']);
    }
}
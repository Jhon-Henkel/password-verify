<?php

namespace tests\Unit\BO;

use PHPUnit\Framework\TestCase;
use src\BO\RuleBO;

class RuleBoUnitTest extends TestCase
{
    private RuleBO $bo;

    protected function setUp(): void
    {
        $this->bo = new RuleBO();
    }

    /**
     * @dataProvider dataProviderTestMinSize
     * @param string $string
     * @param int $value
     * @param bool $expect
     * @return void
     */
    public function testMinSize(string $string, int $value, bool $expect)
    {
        $valid = $this->bo->minSize($string, $value);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestMinSize(): array
    {
        return array(
            'testWithStringLessThanValue' => array('string' => 'abc', 'value' => 8, 'expect' => false),
            'testWithStringEqualsValue' => array('string' => 'jhonatan', 'value' => 8, 'expect' => true),
            'testWithStringBiggerThanValue' => array('string' => 'jhonatan-henkel', 'value' => 8, 'expect' => true),
            'testWithStringEmptyValue' => array('string' => '', 'value' => 8, 'expect' => false),
        );
    }

    /**
     * @dataProvider dataProviderTestMinUppercase
     * @param string $string
     * @param int $value
     * @param bool $expect
     * @return void
     */
    public function testMinUppercase(string $string, int $value, bool $expect)
    {
        $valid = $this->bo->minUppercase($string, $value);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestMinUppercase(): array
    {
        return array(
            'testWithUpperCharsLessThanValue' => array('string' => 'aBcD', 'value' => 4, 'expect' => false),
            'testWithUpperCharsEqualsValue' => array('string' => 'JhOnAtaN', 'value' => 4, 'expect' => true),
            'testWithUpperCharsBiggerThanValue' => array('string' => 'JhOnAtAn-HeNkEl', 'value' => 4, 'expect' => true),
            'testWithUpperCharsEmptyValue' => array('string' => '', 'value' => 4, 'expect' => false),
        );
    }

    /**
     * @dataProvider dataProviderTestMinLowercase
     * @param string $string
     * @param int $value
     * @param bool $expect
     * @return void
     */
    public function testMinLowercase(string $string, int $value, bool $expect)
    {
        $valid = $this->bo->minlowercase($string, $value);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestMinLowercase(): array
    {
        return array(
            'testWithLowerCharsLessThanValue' => array('string' => 'aBcD', 'value' => 4, 'expect' => false),
            'testWithLowerCharsEqualsValue' => array('string' => 'JhoNaTaN', 'value' => 4, 'expect' => true),
            'testWithLowerCharsBiggerThanValue' => array('string' => 'JhONAtAN-HEnKeL', 'value' => 4, 'expect' => true),
            'testWithLowerCharsEmptyValue' => array('string' => '', 'value' => 4, 'expect' => false),
        );
    }

    /**
     * @dataProvider dataProviderTestMinDigit
     * @param string $string
     * @param int $value
     * @param bool $expect
     * @return void
     */
    public function testMinDigit(string $string, int $value, bool $expect)
    {
        $valid = $this->bo->minDigit($string, $value);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestMinDigit(): array
    {
        return array(
            'testWithDigitLessThanValue' => array('string' => 'a1c2', 'value' => 4, 'expect' => false),
            'testWithDigitEqualsValue' => array('string' => '1h0n4t4n', 'value' => 4, 'expect' => true),
            'testWithDigitBiggerThanValue' => array('string' => '1h0n4t4n-H3nk3l', 'value' => 4, 'expect' => true),
            'testWithDigitEmptyValue' => array('string' => '', 'value' => 4, 'expect' => false),
        );
    }

    /**
     * @dataProvider dataProviderTestMinSpecialChars
     * @param string $string
     * @param int $value
     * @param bool $expect
     * @return void
     */
    public function testMinSpecialChars(string $string, int $value, bool $expect)
    {
        $valid = $this->bo->minSpecialChars($string, $value);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestMinSpecialChars(): array
    {
        return array(
            'testWithSpecialCharsLessThanValue' => array('string' => '!a@3', 'value' => 4, 'expect' => false),
            'testWithSpecialCharsEqualsValue' => array('string' => 'T#|es%te£', 'value' => 4, 'expect' => true),
            'testWithSpecialCharsBiggerThanValue' => array('string' => '$r(d{po]--%d', 'value' => 4, 'expect' => true),
            'testWithSpecialCharsEmptyValue' => array('string' => '', 'value' => 4, 'expect' => false),
        );
    }

    /**
     * @dataProvider dataProviderTestNoRepeated
     * @param string $string
     * @param bool $expect
     * @return void
     */
    public function testNoRepeated(string $string, bool $expect)
    {
        $valid = $this->bo->noRepeated($string);

        $this->assertEquals($expect, $valid);
    }

    public function dataProviderTestNoRepeated(): array
    {
        return array(
            'testWithNoRepeatedRepeatingChars' => array('string' => 'aabccdeee', 'expect' => false),
            'testWithNoRepeatedNoRepeatingChars' => array('string' => 'testeteste', 'expect' => true),
            'testWithNoRepeatedRepeatingCharsOnStart' => array('string' => 'tteste', 'expect' => false),
            'testWithNoRepeatedRepeatingCharsOnEnd' => array('string' => 'testee', 'expect' => false),
            'testWithNoRepeatedWithEmptyString' => array('string' => '', 'expect' => true),
            'testWithNoRepeatedRepeatingSpecialChars' => array('string' => 'teste##teste', 'expect' => false),
        );
    }

}
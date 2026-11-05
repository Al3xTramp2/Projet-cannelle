<?php

namespace utils\validators;

use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Supalta\Cannelle\utils\validators\CodePostalValidator;

class CodePostalValidatorTest extends TestCase
{

    private CodePostalValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new CodePostalValidator();
    }

    /**
     * @return void
     */
    public function testPostalCodeHasOnlyDigits(): void
    {
        $this->assertFalse($this->validator->validate("12abc"));
        $this->assertFalse($this->validator->validate("1 200"));
        $this->assertFalse($this->validator->validate("-1200"));
    }

    /**
     * @return void
     */
    public function testPostalCodeHas5Characters(): void
    {
        $this->assertTrue($this->validator->validate("69200"));
        $this->assertFalse($this->validator->validate(""));
        $this->assertFalse($this->validator->validate("6920"));
        $this->assertFalse($this->validator->validate("692007"));
    }

    /**
     * @return void
     */
    public function testMetropolitanDepartements(): void
    {
        $this->assertTrue($this->validator->validate("01000"));
        $this->assertTrue($this->validator->validate("69006"));
        $this->assertTrue($this->validator->validate("95000"));
        $this->assertFalse($this->validator->validate("00000"));
        $this->assertFalse($this->validator->validate("96000"));
        $this->assertFalse($this->validator->validate("99999"));
    }

    /**
     * @return void
     */
    public function testOverseasDepartements(): void
    {
        $this->assertTrue($this->validator->validate("97100"));
        $this->assertTrue($this->validator->validate("98600"));
        $this->assertFalse($this->validator->validate("99000"));
        $this->assertFalse($this->validator->validate("97900"));
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
    }
}
<?php

namespace utils\validators;

use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Supalta\Cannelle\utils\validators\PhoneValidator;

class PhoneValidatorTest extends TestCase
{
    private PhoneValidator $validator;

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new PhoneValidator();
    }

    public function testITI() : void {
        $this->assertTrue($this->validator->validate("+33760335117"));
        $this->assertFalse($this->validator->validate("+2760335117"));
    }

    public function testPhoneSizeWithITI(): void{
        $this->assertFalse($this->validator->validate("+3376033511"));
        $this->assertFalse($this->validator->validate("+337603351176"));
        $this->assertTrue($this->validator->validate("+33760335117"));
    }

    public function testPhoneSize() : void {
        $this->assertTrue($this->validator->validate("0123456789"));
        $this->assertFalse($this->validator->validate("012345678"));
        $this->assertFalse($this->validator->validate("012345678910"));
    }

    public function testPhoneWithRepeatedDigits(): void{
        $this->assertFalse($this->validator->validate("1111111111"));
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
    }
}

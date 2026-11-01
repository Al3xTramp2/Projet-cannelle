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

    #[BeforeClass]
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    #[Before]
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new PhoneValidator();
    }

    #[Test]
    public function testITI() : void {
        $this->assertTrue($this->validator->validate("+33760335117"));
        $this->assertFalse($this->validator->validate("+2760335117"));
    }

    #[Test]
    public function testPhoneSizeWithITI(): void{
        $this->assertFalse($this->validator->validate("+3376033511"));
        $this->assertFalse($this->validator->validate("+337603351176"));
        $this->assertTrue($this->validator->validate("+33760335117"));
    }

    #[Test]
    public function testPhoneSize() : void {
        $this->assertTrue($this->validator->validate("0123456789"));
        $this->assertFalse($this->validator->validate("012345678"));
        $this->assertFalse($this->validator->validate("012345678910"));
    }

    #[Test]
    public function testPhoneWithRepeatedDigits(): void{
        $this->assertFalse($this->validator->validate("1111111111"));
    }

    #[After]
    public function tearDown(): void
    {
        parent::tearDown();
    }

    #[AfterClass]
    public static function tearDownAfterClass(): void
    {
    }

}

<?php

namespace utils\validators;

use Supalta\Cannelle\utils\validators\PasswordValidator;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    private PasswordValidator $validator;

    #[BeforeClass]
    public static function setUpBeforeClass(): void{
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    #[Before]
    public function setUp(): void{
        parent::setUp();
        $this->validator = new PasswordValidator();
    }

    #[Test]
    public function testPasswordValide(): void{
        $this->assertTrue($this->validator->validate("123456789+Aze"));
    }

    #[Test]
    public function testPasswordTooShort(): void{
        $this->assertFalse($this->validator->validate("123+Aze"));
    }

    #[Test]
    public function testSpecialCharacter(): void{
        $this->assertTrue($this->validator->validate("123456789+Azerty"));
        $this->assertFalse($this->validator->validate("123456789Azerty"));
    }

    #[Test]
    public function testUppercaseLetter(): void{
        $this->assertTrue($this->validator->validate("123456789+Azerty"));
        $this->assertFalse($this->validator->validate("123456789+azerty"));
    }

    #[Test]
    public function testNumber(): void{
        $this->assertTrue($this->validator->validate("123456789+Azerty"));
        $this->assertFalse($this->validator->validate("Qwertz+Azerty"));
    }

    #[After]
    public function tearDown(): void{
        parent::tearDown();
    }

    #[AfterClass]
    public static function tearDownAfterClass(): void{
        parent::tearDown();
    }


}
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
    }

    #[Test]
    public function testName() : void {
        self::fail("Not implemented yet.");

    }

    #[Test]
    public function testPhoneNumberHas10Digits() : void {
        $this->assertTrue($this->validator->validate("0123456789"));
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

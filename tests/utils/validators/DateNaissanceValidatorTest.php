<?php

namespace utils\validators;

use DateTime;
use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Supalta\Cannelle\utils\validators\DateNaissanceValidator;

class DateNaissanceValidatorTest extends TestCase
{
    private DateNaissanceValidator $validator;

    #[BeforeClass]
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    #[Before]
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new DateNaissanceValidator();
    }

    /**
     * @return void
     */
    #[Test]
    public function testDateFormat(): void
    {
        $this->assertFalse($this->validator->validate("01/01/1990"));
        $this->assertFalse($this->validator->validate("1990-1-1"));
        $this->assertFalse($this->validator->validate("1990-01-01 10:00"));
        $this->assertFalse($this->validator->validate("abc"));
        $this->assertFalse($this->validator->validate(""));
        $this->assertFalse($this->validator->validate(19900101));
    }

    /**
     * @return void
     */
    #[Test]
    public function testDateExists(): void
    {
        $this->assertFalse($this->validator->validate("2021-02-31"));
        $this->assertFalse($this->validator->validate("2021-13-01"));
        $this->assertFalse($this->validator->validate("2030-01-01"));
    }

    /**
     * @return void
     */
    #[Test]
    public function testPersonIs18OrOlder(): void
    {
        $this->assertTrue($this->validator->validate("2007-01-01"));
        $this->assertFalse($this->validator->validate("2010-01-01"));
    }

    /**
     * @return void
     */
    #[Test]
    public function testPersonIs60OrYounger(): void
    {
        $this->assertTrue($this->validator->validate("1980-01-01"));
        $this->assertFalse($this->validator->validate("1960-01-01"));
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
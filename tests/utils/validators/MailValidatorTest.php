<?php

namespace utils\validators;

use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Supalta\Cannelle\utils\validators\MailValidator;

class MailValidatorTest extends TestCase
{
    private MailValidator $validator;

    #[BeforeClass]
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    #[Before]
    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new MailValidator();
    }

    /**
     * @return void
     */
    #[Test]
    public function testDomainHasADot(): void
    {
        $this->assertTrue($this->validator->validate("eleve@eleve.leschartreux.net"));
        $this->assertFalse($this->validator->validate("user@localhost"));
    }

    /**
     * @return void
     */
    #[Test]
    public function testForbiddenCharacters(): void
    {
        $this->assertFalse($this->validator->validate("6 7@x.fr"));
        $this->assertFalse($this->validator->validate("jules@example.com\n"));
        $this->assertFalse($this->validator->validate("é@x.x"));
    }

    /**
     * @return void
     */
    #[Test]
    public function testPartBeforeAtIsNotTooLong(): void
    {
        $this->assertTrue($this->validator->validate(str_repeat("a", 64) . "@x.fr"));
        $this->assertFalse($this->validator->validate(str_repeat("a", 65) . "@x.fr"));
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

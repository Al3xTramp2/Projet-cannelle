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

    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->validator = new MailValidator();
    }

    /**
     * @return void
     */
    public function testDomainHasADot(): void
    {
        $this->assertTrue($this->validator->validate("eleve@eleve.leschartreux.net"));
        $this->assertFalse($this->validator->validate("user@localhost"));
    }

    /**
     * @return void
     */
    public function testForbiddenCharacters(): void
    {
        $this->assertFalse($this->validator->validate("6 7@x.fr"));
        $this->assertFalse($this->validator->validate("jules@example.com\n"));
        $this->assertFalse($this->validator->validate("é@x.x"));
    }

    /**
     * @return void
     */
    public function testPartBeforeAtIsNotTooLong(): void
    {
        $this->assertTrue($this->validator->validate(str_repeat("a", 64) . "@x.fr"));
        $this->assertFalse($this->validator->validate(str_repeat("a", 65) . "@x.fr"));
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public static function tearDownAfterClass(): void
    {
    }
}

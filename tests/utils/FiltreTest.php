<?php

namespace utils;

use PHPUnit\Framework\Attributes\After;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Supalta\Cannelle\utils\Filtre;
use Supalta\Cannelle\utils\validators\CodePostalValidator;
use Supalta\Cannelle\utils\validators\DateNaissanceValidator;
use Supalta\Cannelle\utils\validators\MailValidator;
use Supalta\Cannelle\utils\validators\PasswordValidator;
use Supalta\Cannelle\utils\validators\PhoneValidator;

class FiltreTest extends TestCase
{

    private Filtre $filtre;
    private array $validators;

    #[BeforeClass]
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, "method : " . __METHOD__ . " line : " . __LINE__ . " \n IT WORKS \n ");
    }

    #[Before]
    public function setUp(): void
    {
        parent::setUp();
        $this->filtre = new Filtre();
        $this->validators = [
            "CP" => new CodePostalValidator(),
            "DateNaissance" => new DateNaissanceValidator(),
            "Mail" => new MailValidator(),
            "Phone" => new PhoneValidator(),
            "Password" => new PasswordValidator()
        ];
    }

    #[Test]
    public function testPhoneMail(): void{
        $this->filtre->accept("Phone", $this->validators["Phone"]);
        $this->filtre->accept("Mail", $this->validators["Mail"]);
        $array = ["Mail"=>"test@test.com","Phone"=>"+33760335117"];
        $result = $this->filtre->visit($array);
        $this->assertTrue($result["Phone"]);
        $this->assertTrue($result["Mail"]);
    }

    #[Test]
    public function testPhoneMailInverted(): void{
        $this->filtre->accept("Mail", $this->validators["Mail"]);
        $this->filtre->accept("Phone", $this->validators["Phone"]);
        $array = ["Phone"=>"+33760335117","Mail"=>"test@test.com"];
        $result = $this->filtre->visit($array);
        $this->assertTrue($result["Mail"]);
        $this->assertTrue($result["Phone"]);
    }

    #[Test]
    public function testAllValidatorsAndAllKeys(): void{
        $this->filtre->accept("CP", $this->validators["CP"]);
        $this->filtre->accept("DateNaissance", $this->validators["DateNaissance"]);
        $this->filtre->accept("Mail", $this->validators["Mail"]);
        $this->filtre->accept("Phone", $this->validators["Phone"]);
        $this->filtre->accept("Password", $this->validators["Password"]);
        $array = ["CP"=>"69200","DateNaissance"=>"2007-01-01","Mail"=>"test.com","Phone"=>"+33760335117","Password"=>"123456789+Aze"];
        $result = $this->filtre->visit($array);
        $this->assertTrue($result["Password"]);
        $this->assertTrue($result["DateNaissance"]);
        $this->assertFalse($result["Mail"]);
        $this->assertTrue($result["Phone"]);
        $this->assertTrue($result["CP"]);
    }

    #[Test]
    public function testNoValidatorsAndAllKeys(): void{
        $array = ["CP"=>"69200","DateNaissance"=>"2007-01-01","Mail"=>"test.com","Phone"=>"+33760335117","Password"=>"123456789+Aze"];
        $result = $this->filtre->visit($array);
        $this->assertEmpty($result);
    }

    #[Test]
    public function testAllValidatorsAndNoKeys(): void{
        $this->filtre->accept("CP", $this->validators["CP"]);
        $this->filtre->accept("DateNaissance", $this->validators["DateNaissance"]);
        $this->filtre->accept("Mail", $this->validators["Mail"]);
        $this->filtre->accept("Phone", $this->validators["Phone"]);
        $this->filtre->accept("Password", $this->validators["Password"]);
        $array = [];
        $result = $this->filtre->visit($array);
        $this->assertFalse($result["Password"]);
        $this->assertFalse($result["DateNaissance"]);
        $this->assertFalse($result["Mail"]);
        $this->assertFalse($result["Phone"]);
        $this->assertFalse($result["CP"]);
    }

    #[Test]
    public function testNoValidatorsAndNoKeys(): void{
        $array = [];
        $result = $this->filtre->visit($array);
        $this->assertEmpty($result);
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

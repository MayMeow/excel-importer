<?php

namespace MayMeow\ExcelImporter\Test;

use MayMeow\ExcelImporter\Attributes\Between;
use MayMeow\ExcelImporter\Attributes\Each;
use MayMeow\ExcelImporter\Attributes\Email;
use MayMeow\ExcelImporter\Attributes\Max;
use MayMeow\ExcelImporter\Attributes\MaxLength;
use MayMeow\ExcelImporter\Attributes\Min;
use MayMeow\ExcelImporter\Attributes\MinLength;
use MayMeow\ExcelImporter\Attributes\NotEmpty;
use MayMeow\ExcelImporter\Attributes\Regex;
use MayMeow\ExcelImporter\Attributes\Required;
use MayMeow\ExcelImporter\Attributes\Url;
use PHPUnit\Framework\TestCase;

class ValidatorAttributesTest extends TestCase
{
    /** @test */
    public function testRequiredAttribute()
    {
        $required = new Required();
        $this->assertTrue($required->validate(''));
        $this->assertTrue($required->validate('value'));
        $this->assertTrue($required->validate(0));
        $this->assertFalse($required->validate(null));
    }

    /** @test */
    public function testNotEmptyAttribute()
    {
        $notEmpty = new NotEmpty();
        $this->assertFalse($notEmpty->validate(''));
        $this->assertTrue($notEmpty->validate('value'));
        $this->assertTrue($notEmpty->validate(0));
        $this->assertFalse($notEmpty->validate(null));
    }

    /** @test */
    public function testMaxLengthAttribute()
    {
        $maxLength = new MaxLength(5);
        $this->assertTrue($maxLength->validate('12345'));
        $this->assertTrue($maxLength->validate('123'));
        $this->assertFalse($maxLength->validate('123456'));
        $this->assertFalse($maxLength->validate(123456));
    }

    /** @test */
    public function testMinLengthAttribute()
    {
        $minLength = new MinLength(5);
        $this->assertTrue($minLength->validate('12345'));
        $this->assertTrue($minLength->validate('123456'));
        $this->assertFalse($minLength->validate('123'));
        $this->assertFalse($minLength->validate(123));
    }

    /** @test */
    public function testMinAttribute()
    {
        $min = new Min(5);
        $this->assertTrue($min->validate(5));
        $this->assertTrue($min->validate(6));
        $this->assertFalse($min->validate(4));
        $this->assertFalse($min->validate('4'));
        $this->assertFalse($min->validate('abc'));
    }

    /** @test */
    public function testMaxAttribute()
    {
        $max = new Max(5);
        $this->assertTrue($max->validate(5));
        $this->assertTrue($max->validate(4));
        $this->assertFalse($max->validate(6));
        $this->assertFalse($max->validate('6'));
        $this->assertFalse($max->validate('abc'));
    }

    /** @test */
    public function testBetweenAttribute()
    {
        $between = new Between(5, 10);
        $this->assertTrue($between->validate(5));
        $this->assertTrue($between->validate(7));
        $this->assertTrue($between->validate(10));
        $this->assertFalse($between->validate(4));
        $this->assertFalse($between->validate(11));
        $this->assertFalse($between->validate('7'));
        $this->assertFalse($between->validate('abc'));
    }

    /** @test */
    public function testEmailAttribute()
    {
        $email = new Email();
        $this->assertTrue($email->validate('test@example.com'));
        $this->assertFalse($email->validate('invalid-email'));
        $this->assertFalse($email->validate(''));
        $this->assertFalse($email->validate(123));
    }

    /** @test */
    public function testUrlAttribute()
    {
        $url = new Url();
        $this->assertTrue($url->validate('https://example.com'));
        $this->assertTrue($url->validate('http://example.com'));
        $this->assertFalse($url->validate('invalid-url'));
        $this->assertFalse($url->validate(''));
        $this->assertFalse($url->validate(123));
    }

    /** @test */
    public function testRegexAttribute()
    {
        $regex = new Regex('/^[a-z]+$/');
        $this->assertTrue($regex->validate('abc'));
        $this->assertFalse($regex->validate('123'));
        $this->assertFalse($regex->validate('abc123'));
        $this->assertFalse($regex->validate(''));
        $this->assertFalse($regex->validate(123));
    }

    /** @test */
    public function testEachAttribute()
    {
        $eachMin = new Each(new Min(5));
        $this->assertTrue($eachMin->validate([5, 6, 7]));
        $this->assertFalse($eachMin->validate([5, 4, 7]));
        $this->assertFalse($eachMin->validate(123));
        
        $eachEmail = new Each(new Email());
        $this->assertTrue($eachEmail->validate(['test@example.com', 'other@example.com']));
        $this->assertFalse($eachEmail->validate(['test@example.com', 'invalid-email']));
    }
}
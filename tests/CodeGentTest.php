<?php

use CouponGenerator\CouponGenerator;
use PHPUnit\Framework\TestCase;

class CodeGentTest extends TestCase
{
    
     public function testObjectInstance()
     {
         $obj = CouponGenerator::getInstance();
         $this->assertIsObject($obj);
     }

    public function testGenerateCodeWithPrefix()
    {
        $obj = CouponGenerator::getInstance(4,5,'test');
        $this->assertIsObject($obj);

        $code = $obj->generateCode();
        $this->assertIsString($code);
        $this->assertNotEmpty($code);
        echo $code;
        $this->assertStringContainsString('test', $code);

    }

    public function testGenerateCodeWithoutPrefix()
    {
        $obj = CouponGenerator::getInstance(2,6);
        $this->assertIsObject($obj);

        $code = $obj->generateCode();
        $this->assertIsString($code);
        $this->assertNotEmpty($code);
        echo $code;
    }

    public function testGenerateCodeSingleLineDefault()
    {
        $code = CouponGenerator::getInstance()->generateCode();
        $this->assertIsString($code);
        $this->assertNotEmpty($code);
        echo $code;
    }

    public function testGenerateCodeSingleLineWithDifferentSymbolSetAndSequenceBytes()
    {

        $code = CouponGenerator::getInstance(5,5,'STORE')->generateCode();
        $this->assertIsString($code);
        $this->assertNotEmpty($code);
        echo $code;
    }





}
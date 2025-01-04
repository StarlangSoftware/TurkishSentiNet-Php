<?php


use olcaytaner\Sentinet\SentiLiteralNet;
use PHPUnit\Framework\TestCase;

class SentiLiteralNetTest extends TestCase
{
    public function testSentiNet(){
        $sentinet = new SentiLiteralNet();
        $this->assertCount(4335, $sentinet->getPositives());
        $this->assertCount(13011, $sentinet->getNegatives());
        $this->assertCount(62379, $sentinet->getNeutrals());
    }
}

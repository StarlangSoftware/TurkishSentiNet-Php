<?php


use olcaytaner\Sentinet\SentiNet;
use PHPUnit\Framework\TestCase;

class SentiNetTest extends TestCase
{
    public function testSentiNet(){
        $sentinet = new SentiNet();
        $this->assertCount(3100, $sentinet->getPositives());
        $this->assertCount(10191, $sentinet->getNegatives());
        $this->assertCount(63534, $sentinet->getNeutrals());
    }

}

<?php

namespace CommissionTask\Tests\Service;

use CommissionTask\Script\ReflectionResolver;
use CommissionTask\Script\Script;
use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{
    private $controller;

    public function setUp()
    {
        $resolver = new ReflectionResolver();
        $this->controller = $resolver->resolve(Script::class);
    }

    /**
     * set CommissionTask\Config\CommissionConfig::is_production = false
    */
    public function testEndToEnd()
    {
        $transactions = $this->controller->main("input.csv");

        $this->assertEquals([0.60, 3.00, 0.00, 0.06, 1.50, 0.00, 0.69, 0.30, 0.30, 3.00, 0.00, 0.00, 8611.41], $transactions);
    }

}
<?php

declare(strict_types=1);

namespace CommissionTask\Tests\Service;

use CommissionTask\Script\ReflectionResolver;
use CommissionTask\Script\Script;
use CommissionTask\Service\CommissionService\Withdraw\PrivateUserWithdrawCommissionFee;
use PHPUnit\Framework\TestCase;
use CommissionTask\Service\RateService\RateService;

class PrivateClientCommissionTest extends TestCase
{
    /**
     * @var ReflectionResolver
     */
    private $controller;
    private $transaction_data;

    public function setUp()
    {
        $resolver = new ReflectionResolver();
        $this->controller = $resolver->resolve(PrivateUserWithdrawCommissionFee::class);

        $this->transaction_data = [
            'operation_date' => "2020-12-31",
            'user_id' => 4,
            'user_type' => "private",
            'operation_type' => "withdraw",
            'operation_amount' => 1200.00,
            'operation_currency' => "EUR"
        ];
    }

    /**
     * set CommissionTask\Config\CommissionConfig::is_production = false
     */

    public function testCalculateFee()
    {
        $this->assertEquals(
            0.60,
            $this->controller->calculateFee($this->transaction_data)
        );
    }


}

<?php

namespace CommissionTask\Service\CommissionService\Deposit;


use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CommissionService\InterfaceCalculateCommissionFee;
use CommissionTask\Service\RateService\RateService;

class CalculateDepositFee implements InterfaceCalculateCommissionFee
{

    protected $rateService;
    private static $depositRate = CommissionConfig::depositRate;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function calculateFee($transaction_data): float
    {
        return $this->rateService->getFeeByTransactionAmountAndRate($transaction_data['operation_amount'], self::$depositRate);
    }

}
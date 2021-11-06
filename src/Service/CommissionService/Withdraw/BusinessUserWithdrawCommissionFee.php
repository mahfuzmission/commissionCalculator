<?php

namespace CommissionTask\Service\CommissionService\Withdraw;

use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CommissionService\InterfaceCalculateCommissionFee;
use CommissionTask\Service\RateService\RateService;

class BusinessUserWithdrawCommissionFee implements InterfaceCalculateCommissionFee
{

    protected $rateService;
    private static $businessClientWithdrawRate = CommissionConfig::businessClientWithdrawRate;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function calculateFee($transaction_data): float
    {
        return $this->rateService->getFeeByTransactionAmountAndRate($transaction_data['operation_amount'], self::$businessClientWithdrawRate);
    }
}
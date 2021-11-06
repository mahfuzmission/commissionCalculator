<?php

namespace CommissionTask\Service\CommissionService\Withdraw;


use CommissionTask\Service\CommissionService\InterfaceCalculateCommissionFee;

class CalculateWithdrawFee implements InterfaceCalculateCommissionFee
{
    private $privateUserWithdrawCommissionFee;
    private $businessUserWithdrawCommissionFee;

    public function __construct(
        BusinessUserWithdrawCommissionFee $businessUserWithdrawCommissionFee,
        PrivateUserWithdrawCommissionFee $privateUserWithdrawCommissionFee
    )
    {
        $this->privateUserWithdrawCommissionFee = $privateUserWithdrawCommissionFee;
        $this->businessUserWithdrawCommissionFee = $businessUserWithdrawCommissionFee;

    }

    public function calculateFee($transaction_data): float
    {
        if($transaction_data['user_type'] == "business")
        {
            return $this->businessUserWithdrawCommissionFee->calculateFee($transaction_data);
        }
        else
        {
            return $this->privateUserWithdrawCommissionFee->calculateFee($transaction_data);
        }
    }
}
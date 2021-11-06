<?php


namespace CommissionTask\Service\CommissionService;

use CommissionTask\Service\CommissionService\Deposit\CalculateDepositFee;
use CommissionTask\Service\CommissionService\Withdraw\CalculateWithdrawFee;

class TransactionCommissionService
{

    private $calculateWithdrawFee;
    private $calculateDepositFee;

    public function __construct(
        CalculateWithdrawFee $calculateWithdrawFee,
        CalculateDepositFee $calculateDepositFee
    ){
        $this->calculateWithdrawFee = $calculateWithdrawFee;
        $this->calculateDepositFee = $calculateDepositFee;
    }

    public function calculateFees($transaction_data): float {
        $chargeFee = 0.00;

        if($transaction_data['operation_type'] == "deposit")
        {
            $chargeFee = $this->calculateDepositFee->calculateFee($transaction_data);
        }
        if($transaction_data['operation_type'] == "withdraw")
        {
            $chargeFee =  $this->calculateWithdrawFee->calculateFee($transaction_data);
        }

        return (float) number_format((double)$chargeFee, 2, '.', '');
    }
}
<?php

namespace CommissionTask\Service\CommissionService\Withdraw;

use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CommissionService\InterfaceCalculateCommissionFee;
use CommissionTask\Service\RateService\RateService;


class PrivateUserWithdrawCommissionFee implements InterfaceCalculateCommissionFee
{
    private static $privateWithdrawHistory = [];
    private static $defaultCurrency = CommissionConfig::defaultCurrency;
    private static $freeWeeklyWithdrawCount = CommissionConfig::freeWeeklyWithdrawCount;
    private static $privateClientWithdrawRate = CommissionConfig::privateClientWithdrawRate;
    private static $freeWeeklyWithdrawAmount = CommissionConfig::freeWeeklyWithdrawAmount;
    protected $rateService;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
    }

    public function calculateFee($transaction_data): float
    {
        $userId = $transaction_data['user_id'];
        $date = $transaction_data['operation_date'];
        $withdrawAmount = (float) $transaction_data['operation_amount'];
        $originalAmount = $withdrawAmount;
        $currency = $transaction_data['operation_currency'];

        $lastMonday = self::getLastMonday($date);
        $this->initialiseUserPrivateHistory($userId, $lastMonday);

        if($currency != self::$defaultCurrency) {
            $withdrawAmount = $this->rateService->ConvertToDefaultCurrency($withdrawAmount, $currency);
        }

        $this->populateUserPrivateHistory($userId, $lastMonday, $withdrawAmount);
        $numberOfTransactions = $this->countWeeklyUserTransaction($userId, $lastMonday);
        $totalAmountOfTransaction = $this->sumWeeklyUserTransactionAmount($userId, $lastMonday);

        if($numberOfTransactions > self::$freeWeeklyWithdrawCount)
        {
            return $this->rateService->getFeeByTransactionAmountAndRate($originalAmount, self::$privateClientWithdrawRate);
        }

        return $this->getCommissionFee($originalAmount, $withdrawAmount, $totalAmountOfTransaction, $currency);
    }

    private function getLastMonday($date)
    {
         return date('Y-m-d', strtotime('previous monday', strtotime($date)));
    }

    private function initialiseUserPrivateHistory($userId, $lastMonday)
    {
        if(!array_key_exists($userId, self::$privateWithdrawHistory)) {
            self::$privateWithdrawHistory[$userId] = [];
        }
        if(!array_key_exists($lastMonday, self::$privateWithdrawHistory[$userId])) {
            self::$privateWithdrawHistory[$userId][$lastMonday] = [];
        }
    }

    private function populateUserPrivateHistory($userId, $lastMonday, $withdrawAmount)
    {
        array_push(self::$privateWithdrawHistory[$userId][$lastMonday], $withdrawAmount);
    }

    private function countWeeklyUserTransaction($userId, $lastMonday): int
    {
        return count(self::$privateWithdrawHistory[$userId][$lastMonday]);
    }

    private function sumWeeklyUserTransactionAmount($userId, $lastMonday) : float
    {
        return (float) array_sum(self::$privateWithdrawHistory[$userId][$lastMonday]);
    }

    private function getCommissionFee($originalAmount, $withdrawAmount, $totalAmountOfTransaction, $currency)
    {
        if($totalAmountOfTransaction > self::$freeWeeklyWithdrawAmount) {
            if(($totalAmountOfTransaction - $withdrawAmount) > self::$freeWeeklyWithdrawAmount)
            {
                return $this->rateService->getFeeByTransactionAmountAndRate($originalAmount,  self::$privateClientWithdrawRate);
            }

            $remainingAmount = $totalAmountOfTransaction - self::$freeWeeklyWithdrawAmount;

            if($currency != self::$defaultCurrency)
            {
                $remainingAmount = $this->rateService->ConvertToUserCurrency($remainingAmount , $currency);
            }

            return $this->rateService->getFeeByTransactionAmountAndRate($remainingAmount,  self::$privateClientWithdrawRate);
        }

        return 0;
    }
}
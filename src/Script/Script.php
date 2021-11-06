<?php
namespace CommissionTask\Script;

use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CommissionService\TransactionCommissionService;
use CommissionTask\Service\CommissionService\LoadTransactionData\TransactionFileDataLoader;

class Script {

    public $transactionCommissionService;

    public function __construct(TransactionCommissionService $transactionCommissionService)
    {
        $this->transactionCommissionService = $transactionCommissionService;
    }

    public function calculateRates($transactionFileDataLoader) {
        try {
            $commissionFees = [];
            $fileLines = $transactionFileDataLoader->getData();

            foreach ($fileLines as $transaction_data) {
                $commissionFees[] = $this->transactionCommissionService->calculateFees($transaction_data);
            }

            return $commissionFees;
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function main($fileName)
    {
        if(!$fileName)
        {
            $fileName = CommissionConfig::defaultFileName;
        }

        $transactionFileDataLoader = new TransactionFileDataLoader($fileName);
        return $this->calculateRates($transactionFileDataLoader);
    }

}

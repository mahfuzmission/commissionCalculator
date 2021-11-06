<?php

namespace CommissionTask\Service\CommissionService\LoadTransactionData;

use CommissionTask\Config\CommissionConfig;
use Exception;

class TransactionFileDataLoader
{
    private $filePath;

    /**
     * @param  string  $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    /**
     * @throws Exception
     */
    public function getData(): array
    {
        if (!file_exists($this->filePath)) {
            throw new Exception($this->filePath . ' is not valid file path or file couldn\'t be loaded');
        }

        return $this->loadFileData();
    }

    private function loadFileData(): array
    {
        $allowColumnCount = count(CommissionConfig::commissionKeyMap);

        $lines = [];
        if (($line = fopen($this->filePath, "r")) !== FALSE) {
            while (($transactionData = fgetcsv($line, null)) !== FALSE) {
                if(count($transactionData) == $allowColumnCount)
                {
                    $lines[] = $this->columnMappingWithData($transactionData);
                }
                else
                {
                    echo "row does not have all the columns \n ->".json_encode($transactionData)."\n\n\n";
                }
            }
            fclose($line);
        }
        else
        {
            throw new \RuntimeException('Failed to open file');
        }

        return $lines;
    }

    private function columnMappingWithData($arrayData)
    {
        return array_combine(CommissionConfig::commissionKeyMap, $arrayData);
    }
}
<?php

namespace CommissionTask\Tests\Service;

use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CommissionService\LoadTransactionData\TransactionFileDataLoader;
use PHPUnit\Framework\TestCase;

class TransactionDataMapTest extends TestCase
{
    protected $dataLoader;

    public function setUp()
    {
        $this->dataLoader = new TransactionFileDataLoader("input.csv");
    }


    public function testLoadedDataKeyCountMatch()
    {
        $transactionsData =  $this->dataLoader->getData();

        $this->assertSameSize(CommissionConfig::commissionKeyMap, $transactionsData[0]);
    }

}
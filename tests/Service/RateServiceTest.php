<?php

declare(strict_types=1);

namespace CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use CommissionTask\Service\RateService\RateService;

class RateServiceTest extends TestCase
{
    /**
     * @var RateService
     */
    private $rateService;

    public function setUp()
    {
        $this->rateService = new RateService();
    }


    public function testGetFeeByTransactionAmountAndRate()
    {
        $this->assertEquals(
            0.06,
            $this->rateService->getFeeByTransactionAmountAndRate(200.00, 0.03)
        );
    }

    public function testConvertToUserCurrency()
    {
        $this->assertEquals(388590000.0,
            $this->rateService->ConvertToUserCurrency(3000000, 'JPY')

        );
    }

    public function testConvertToDefaultCurrency()
    {
        $this->assertEquals(3000000,
            $this->rateService->ConvertToDefaultCurrency(388590000, 'JPY')

        );
    }

}

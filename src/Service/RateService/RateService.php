<?php

namespace CommissionTask\Service\RateService;

use CommissionTask\Config\CommissionConfig;
use CommissionTask\Service\CurrencyRate\TransactionRateApiService;

class RateService
{

    private static $rates = [];

    public function __construct()
    {
        if(! count(self::$rates))
        {
            self::$rates = self::getExchangeRates();
        }
    }

    public function getFeeByTransactionAmountAndRate($amount, $rate) : float
    {
        return (float) (($rate * $amount) / 100.0);
    }

    public function ConvertToUserCurrency($amount, $currency): float
    {
        return (float)($amount * self::$rates[$currency]);
    }

    public function ConvertToDefaultCurrency($amount, $currency): float
    {
        return (float)( $amount / self::$rates[$currency]);
    }

    private static function getExchangeRates()
    {
        if(CommissionConfig::is_production)
        {
            return ( new TransactionRateApiService() )->fetchExchangeRates();
        }
        else
        {
            $content = file_get_contents("currency.json");
            $json = json_decode($content, true);
            return $json["rates"];
        }
    }



}
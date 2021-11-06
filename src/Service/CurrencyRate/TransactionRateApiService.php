<?php


namespace CommissionTask\Service\CurrencyRate;


use CommissionTask\Config\CommissionConfig;

class TransactionRateApiService
{
    private static $endpoint = CommissionConfig::exchangeRateApiUrl;
    private static $accessKey = CommissionConfig::apiKey;

    public function fetchExchangeRates() {
        try {
            $curl = curl_init(self::$endpoint . "?access_key=" .self::$accessKey);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);

            curl_close($curl);

            $json = json_decode($result, true);

            if(isset($json["success"]) && $json["success"]) {
                return $json["rates"];
            }
            return null;
        }
        catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }

    }
}








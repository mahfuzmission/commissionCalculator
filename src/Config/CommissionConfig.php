<?php

namespace CommissionTask\Config;

final class CommissionConfig
{
    const is_production = true;//set to false before running unit test cases

    const commissionKeyMap = [
      'operation_date',
      'user_id',
      'user_type',
      'operation_type',
      'operation_amount',
      'operation_currency',
    ];

    const exchangeRateApiUrl = 'http://api.exchangeratesapi.io/latest';
    const apiKey = '191b99628199a34f93b6ae98f355c395';

    const defaultCurrency = 'EUR';
    const freeWeeklyWithdrawCount = 3;
    const freeWeeklyWithdrawAmount = 1000;
    const depositRate = 0.03;
    const privateClientWithdrawRate = 0.3;
    const businessClientWithdrawRate = 0.5;

    const defaultFileName = "input.csv";

}
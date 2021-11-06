<?php

namespace CommissionTask\Service\CommissionService;

interface InterfaceCalculateCommissionFee
{
    public function calculateFee($transaction_data): float;
}
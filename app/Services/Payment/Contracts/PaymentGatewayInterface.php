<?php
namespace App\Services\Payment\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * Process payment for the given order
     *
     * @return PaymentResult
     */
    public function charge(Order $order): array;
}

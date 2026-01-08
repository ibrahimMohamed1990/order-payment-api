<?php
namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGatewayInterface;

class CreditCardGateway implements PaymentGatewayInterface
{
    public function charge(Order $order): array
    { 
        $success = rand(0, 1);

        return [
            'status'    => $success ? 'successful' : 'failed',
            'reference' => 'CC-' . strtoupper(uniqid()),
            'message'   => $success
                ? 'Credit card payment successful'
                : 'Credit card payment failed',
        ];
    }
}

<?php
namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGatewayInterface;

class PaypalGateway implements PaymentGatewayInterface
{
    public function charge(Order $order): array
    {
        return [
            'status'    => 'successful',
            'reference' => 'PAYPAL-' . strtoupper(uniqid()),
            'message'   => 'PayPal payment completed',
        ];
    }
}

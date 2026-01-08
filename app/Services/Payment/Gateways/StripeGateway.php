<?php
namespace App\Services\Payment\Gateways;

use App\Models\Order;
use App\Services\Payment\Contracts\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    public function charge(Order $order): array
    {
        return [
            'status'    => 'successful',
            'reference' => 'STRIPE-' . uniqid(),
            'message'   => 'Stripe payment succeeded',
        ];
    }
}

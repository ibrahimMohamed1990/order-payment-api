<?php
namespace App\Services\Payment;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Gateways\CreditCardGateway;
use App\Services\Payment\Gateways\PaypalGateway;
use App\Services\Payment\Gateways\StripeGateway;
use InvalidArgumentException;

class PaymentManager
{
    public static function make(string $method): PaymentGatewayInterface
    {
        return match ($method) {
            'credit_card' => new CreditCardGateway(),
            'paypal'      => new PaypalGateway(),
            'stripe'      => new StripeGateway(),
            default       => throw new InvalidArgumentException(
                "Unsupported payment method: {$method}"
            ),
        };
    }
}

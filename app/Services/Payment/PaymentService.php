<?php
namespace App\Services\Payment;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class PaymentService
{
    public function process(Order $order, string $method): Payment
    {
        if ($order->status !== Order::STATUS_CONFIRMED) {
            throw ValidationException::withMessages([
                'order' => 'Payment allowed only for confirmed orders'
            ]);
        }

        return DB::transaction(function () use ($order, $method) {

            $gateway = PaymentManager::make($method);
            $result  = $gateway->charge($order);

            return Payment::create([
                'order_id'         => $order->id,
                'payment_method'   => $method,
                'status'           => $result['status'],
            ]);
        });
    }
}

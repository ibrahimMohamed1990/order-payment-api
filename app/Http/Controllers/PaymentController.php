<?php
namespace App\Http\Controllers;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;


class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'payment_method' => 'required|string',
        ]);

        $order   = Order::findOrFail($data['order_id']);
        $payment = $this->paymentService
            ->process($order, $data['payment_method']);

        return response()->json($payment, 201);
    }
    public function show($orderId)
{
    $payments = Payment::where('order_id', $orderId)->get();

    return response()->json($payments);
}

}

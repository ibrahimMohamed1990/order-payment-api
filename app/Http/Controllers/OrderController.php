<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller; 
use App\Services\Order\OrderService;


class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}
public function index(Request $request)
{
    $orders = Order::with(['items', 'payments'])
        ->where('user_id', auth()->id())
        ->when($request->status, fn ($q) =>
            $q->where('status', $request->status)
        )
        ->paginate(10);

    return response()->json($orders);
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.price'        => 'required|numeric|min:0',
        ]);

        $order = $this->orderService
            ->create($data['items'], auth()->id());

        return response()->json($order, 201);
    }

    public function confirm(Order $order)
    {
        $order = $this->orderService
            ->confirm($order, auth()->id());

        return response()->json($order);
    }

    public function cancel(Order $order)
    {
        $order = $this->orderService
            ->cancel($order, auth()->id());

        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);
        return response()->noContent();
    }

    public function show(Order $order)
{
    $order->load(['items', 'payments']);

    return response()->json([
        'id'     => $order->id,
        'status' => $order->status,
        'total'  => $order->total,
        'items'  => $order->items,
        'payments' => $order->payments,
        'created_at' => $order->created_at,
    ]);
}

}

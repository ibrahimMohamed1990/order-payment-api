<?php
namespace App\Services\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function create(array $items, int $userId): Order
    {
        return DB::transaction(function () use ($items, $userId) {

            $total = collect($items)
                ->sum(fn ($item) => $item['quantity'] * $item['price']);

            $order = Order::create([
                'user_id' => $userId,
                'total'   => $total,
                'status'  => Order::STATUS_PENDING,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            return $order->load('items');
        });
    }

    public function confirm(Order $order, int $userId): Order
    {
        $this->authorizeOwner($order, $userId);

        if ($order->status !== Order::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'order' => 'Only pending orders can be confirmed'
            ]);
        }

        $order->update(['status' => Order::STATUS_CONFIRMED]);
        return $order;
    }

    public function cancel(Order $order, int $userId): Order
    {
        $this->authorizeOwner($order, $userId);

        if ($order->status === Order::STATUS_CONFIRMED) {
            throw ValidationException::withMessages([
                'order' => 'Confirmed orders cannot be cancelled'
            ]);
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);
        return $order;
    }

    public function delete(Order $order): void
    {
        if ($order->payments()->exists()) {
            throw ValidationException::withMessages([
                'order' => 'Order cannot be deleted because it has payments'
            ]);
        }

        $order->delete();
    }

    private function authorizeOwner(Order $order, int $userId): void
    {
        if ($order->user_id !== $userId) {
            throw ValidationException::withMessages([
                'authorization' => 'You do not own this order'
            ]);
        }
    }
}

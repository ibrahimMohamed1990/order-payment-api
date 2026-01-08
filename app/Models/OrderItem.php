<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 use App\Models\Order;


class OrderItem extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'price',
    ];

    /* ======================
     | Relationships
     ====================== */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

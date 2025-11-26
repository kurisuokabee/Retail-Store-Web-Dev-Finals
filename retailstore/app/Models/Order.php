<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'customer_id',
        'order_date',
        'order_status',
        'total_amount',
        'payment_status',
        'payment_method',
        'shipping_address',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function orderDetails() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    
}

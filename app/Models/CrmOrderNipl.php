<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmOrderNipl extends Model
{
    use HasFactory;
    protected $table = 'crm_orders_nipl';
    protected $fillable = [
        'title',
        'batch_number',
        'product_id',
        'demand_quantity',
        'deliver_quantity',
        'product_price',
        'currency',
        'order_type',
        'is_auto_accept',
        'pump_number',
        'pump_id',
        'refund_amt',
        'accept_amt',
        'total_order_amt',
        'user_id',
        'card_id',
        'store_owner_id',
        'store_id',
        'store_station_id',
        'cashier_id',
        'status',
        'reference',
        'approval_code',
        'inserted_date',
        'accepted_date',
        'delivery_date',
        'completed_date',
        'refund_date',
        'last_modified',
        'author_id',
        'deleted',
        'order_for',
        'payment_from',
        'parent_order_id',
        'pump_number_title',
        'order_payment_type',
        'demand_litres',
        'accept_litres',
        'delivered_litres',
        'refund_litres',
        'phone_id',
        'discount_sum',
        'external_id',
        'money_balance_id',
        'liter_balance_id',
    ];
}

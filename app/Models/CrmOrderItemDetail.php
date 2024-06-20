<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmOrderItemDetail extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'crm_order_item_detail';
    protected $fillable
        = [
            'order_nipl_id',
            'product_id',
            'amt',
            'quantity'
        ];
}

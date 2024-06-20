<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmVirtualCart extends Model
{
    use HasFactory;

    protected $table = 'crm_virtual_carts';
    protected $fillable
        = [
            'guid',
            'pan',
            'phone_number',
            'is_used'
        ];
}

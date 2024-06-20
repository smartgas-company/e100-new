<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmStore extends Model
{
    use HasFactory;
    protected $table = 'crm_stores';
    protected $fillable = [
        'wifi_name',
        'title',
        'company_name',
        'description',
        'price_currency',
        'address',
        'city',
        'phone',
        'total_pump',
        'is_grocery',
        'category_id',
        'owner_id',
        'cashier_id',
        'manager_id',
        'img',
        'thumbnail',
        'date_added',
        'last_modified',
        'author_id',
        'disabled',
        'deleted',
        'latitude',
        'longitude',
        'grocery_owner',
        'fuel_company_id',
        'store_side',
        'retalix_station_id',
        'yandex_store_id',
        'active',
    ];
}

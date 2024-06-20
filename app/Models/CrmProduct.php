<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmProduct extends Model
{
    use HasFactory;
    protected $table = 'crm_products';
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'price',
        'weight',
        'weight_unit',
        'product_type',
        'is_featured',
        'img',
        'thumbnail',
        'date_added',
        'last_modified',
        'author_id',
        'disabled',
        'deleted',
        'parent_product_id',
        'disabled_for_agent',
        'item_code',
    ];
}

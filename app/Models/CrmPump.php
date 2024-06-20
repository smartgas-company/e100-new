<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrmPump extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'crm_pumps';
    protected $primaryKey = 'pump_id';
    protected $fillable = [
        'title',
        'store_id',
        'store_product_id',
        'columnid',
        'status',
        'disabled',
        'deleted',
        'date_added',
        'last_modified',
    ];
    protected array $indexes = [
        'title',
        'store_id',
        'disabled',
        'deleted',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(CrmStore::class, 'store_id', 'id');
    }
}

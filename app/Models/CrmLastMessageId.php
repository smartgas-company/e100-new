<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrmLastMessageId extends Model
{
    use HasFactory;
    protected $table = 'crm_last_message_ids';
    protected $fillable = [
        'order_id',
        'last_message_id',
        'cancel_reason',
        'type'
    ];

    public function orderNipl(): BelongsTo
    {
        return $this->belongsTo(CrmOrderNipl::class, 'order_id', 'id');
    }
}

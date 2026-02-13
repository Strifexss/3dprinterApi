<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemReservation extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'item_reservations';
    protected $fillable = [
        'id',
        'tenant_id',
        'budget_id',
        'product_id',
        'quantity',
        'status',
        'reservation_date',
        'expire_date',
        'note',
        'created_at',
    ];
    
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

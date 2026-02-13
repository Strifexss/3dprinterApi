<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrderItem extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'service_order_items';
    const UPDATED_AT = null;

    protected $fillable = [
        'id',
        'tenant_id',
        'service_order_id',
        'product_id',
        'quantity',
        'created_at',
    ];

    public function serviceOrder(): BelongsTo
    {
        return $this->belongsTo(ServiceOrder::class, 'service_order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

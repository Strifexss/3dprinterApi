<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceOrder extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'service_orders';

    protected $fillable = [
        'id',
        'tenant_id',
        'budget_id',
        'client_id',
        'description',
        'notes',
        'printer_id',
        'responsible_id',
        'expected_date',
        'delivery_date',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ServiceOrderItem::class, 'service_order_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class);
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }
}

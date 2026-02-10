<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'budgets';
    protected $fillable = [
        'id',
        'tenant_id',
        'status',
        'description',
        'client_id',
        'internal_note',
        'price',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BudgetItem::class);
    }
}

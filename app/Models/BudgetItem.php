<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetItem extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'budget_items';
    protected $fillable = [
        'id',
        'tenant_id',
        'budget_id',
        'product_id',
        'quantity',
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'model',
        'manufacturer',
        'serial_number',
        'technology',
        'acquisition_date',
        'warranty_until',
        'status',
        'location',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanBoard extends Model
{
    protected $table = 'kanban_boards';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'tenant_id',
        'printer_id',
        'from_status',
        'to_status',
        'changed_by_id',
        'changed_at',
        'notes',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'client_id', 'tenant_id', 'nome', 'tipo', 'ddd', 'telefone', 'email', 'is_deleted', 'notes', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}

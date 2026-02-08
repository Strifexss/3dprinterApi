<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'nome',
        'razao_social',
        'cpf_cnpj',
        'tipo_pessoa',
        'extras',
        'created_by',
        'updated_by',
        'fulltext_nome',
    ];

    public function contacts()
    {
        return $this->hasMany(\App\Models\Contact::class, 'client_id', 'id');
    }
}

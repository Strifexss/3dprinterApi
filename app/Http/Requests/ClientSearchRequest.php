<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class ClientSearchRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome' => 'nullable|string',
            'cpf_cnpj' => 'nullable|string',
            'tipo_pessoa' => 'nullable|in:F,J',
        ];
    }

    public function all($keys = null)
    {
        $data = parent::all($keys);
        return $data;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSearchRequest extends FormRequest
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
        if ($this->user() && isset($this->user()->tenant_id)) {
            $data['tenant_id'] = $this->user()->tenant_id;
        }
        return $data;
    }
}

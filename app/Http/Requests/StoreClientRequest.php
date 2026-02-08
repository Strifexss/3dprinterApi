<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
   
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'nome' => 'required|string|max:255',
            'razao_social' => 'nullable|string|max:255',
            'cpf_cnpj' => 'required|string|max:20|unique:clients,cpf_cnpj',
            'tipo_pessoa' => 'required|in:F,J',
            'extras' => 'nullable|array',
            'created_by' => 'nullable|uuid',
            'updated_by' => 'nullable|uuid',
        ];
    }

    public function validated($key = null, $default = null)
    
    {
        $data = parent::validated($key, $default);
        if ($this->user() && isset($this->user()->tenant_id)) {
            $data['tenant_id'] = $this->user()->tenant_id;
        }
        return $data;
    }

   
}

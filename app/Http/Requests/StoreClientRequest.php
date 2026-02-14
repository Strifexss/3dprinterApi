<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class StoreClientRequest extends AbstractRequest
   
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
            'contatos' => 'nullable|array',
            'contatos.*.nome' => 'required|string|max:255',
            'contatos.*.tipo' => 'required|in:PRINCIPAL,SECUNDARIO',
            'contatos.*.ddd' => 'required|string|max:3',
            'contatos.*.telefone' => 'required|string|max:20',
            'contatos.*.email' => 'required|email|max:255',
            'contatos.*.notes' => 'nullable|string',
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        if (is_array($data) && $this->user() && isset($this->user()->tenant_id)) {
            $data['tenant_id'] = $this->user()->tenant_id;
        }
        
        return $data;
    }
}

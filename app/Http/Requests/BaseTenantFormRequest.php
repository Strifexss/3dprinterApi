<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    public function __construct(...$args)
    {
        parent::__construct(...$args);
        if ($this->user() && isset($this->user()->tenant_id)) {
            $this->merge(['tenant_id' => $this->user()->tenant_id]);
        }
    }
}

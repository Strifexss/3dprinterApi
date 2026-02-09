<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class ProductSearchRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        ];
    }

}

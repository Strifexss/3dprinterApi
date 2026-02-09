<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class StoreProductRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ...existing rules...
        ];
    }

}

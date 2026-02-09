<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class StoreProductGroupRequest extends AbstractRequest
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

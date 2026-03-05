<?php

namespace App\Http\Requests;

use App\Http\Requests\AbstractRequest;

class UpdateProductGroupRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'is_active'   => 'sometimes|boolean',
        ];
    }
}

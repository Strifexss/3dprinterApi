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
                'name'        => 'required|string|unique:product_groups,name|max:255',
                'description' => 'nullable|string',
                'is_active'   => 'required|boolean',
            ];
        }

}

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
            'group_id'    => 'required|uuid',
            'sku'         => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'unit'        => 'required|string|max:10',
            'color'       => 'nullable|string|max:50',
            'material'    => 'nullable|string|max:50',
            'min_stock'   => 'required|integer|min:0',
            'is_active'   => 'required|boolean',
        ];
    }

}

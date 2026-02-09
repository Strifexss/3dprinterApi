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
            'group_id' => 'nullable|uuid',
            'name' => 'nullable|string|max:255',
            'tenant_id'   => 'nullable|uuid',
            'sku'         => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'unit'        => 'nullable|string|max:10',
            'color'       => 'nullable|string|max:50',
            'material'    => 'nullable|string|max:50',
            'min_stock'   => 'nullable|numeric',
            'is_active'   => 'nullable|boolean',
            ];
    }
}

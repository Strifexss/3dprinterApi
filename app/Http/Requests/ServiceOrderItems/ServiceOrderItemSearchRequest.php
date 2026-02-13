<?php

namespace App\Http\Requests\ServiceOrderItems;

use App\Http\Requests\AbstractRequest;

class ServiceOrderItemSearchRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'service_order_id' => 'nullable|uuid',
            'product_id' => 'nullable|uuid',
        ];
    }
}

<?php

namespace App\Http\Requests\ServiceOrderItems;

use App\Http\Requests\AbstractRequest;

class StoreServiceOrderItemRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'service_order_id' => 'required|uuid|exists:service_orders,id',
            'product_id' => 'nullable|uuid|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];
    }
}

<?php

namespace App\Http\Requests\ServiceOrderItems;

use App\Http\Requests\AbstractRequest;

class UpdateServiceOrderItemRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'sometimes|uuid',
            'service_order_id' => 'sometimes|uuid|exists:service_orders,id',
            'product_id' => 'sometimes|nullable|uuid|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
        ];
    }
}

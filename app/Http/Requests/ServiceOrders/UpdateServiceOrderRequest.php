<?php

namespace App\Http\Requests\ServiceOrders;

use App\Http\Requests\AbstractRequest;

class UpdateServiceOrderRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'sometimes|uuid',
            'budget_id' => 'sometimes|uuid|exists:budgets,id',
            'client_id' => 'sometimes|uuid|exists:clients,id',
            'description' => 'sometimes|nullable|string',
            'notes' => 'sometimes|nullable|string',
            'printer_id' => 'sometimes|integer|exists:printers,id',
            'responsible_id' => 'sometimes|integer|exists:users,id',
            'expected_date' => 'sometimes|nullable|date',
            'delivery_date' => 'sometimes|nullable|date',
            'items' => 'sometimes|array',
            'items.*.product_id' => 'required_with:items|uuid|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ];
    }
}

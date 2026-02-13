<?php

namespace App\Http\Requests\ServiceOrders;

use App\Http\Requests\AbstractRequest;

class StoreServiceOrderRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'budget_id' => 'nullable|uuid|exists:budgets,id',
            'client_id' => 'nullable|uuid|exists:clients,id',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'printer_id' => 'nullable|integer|exists:printers,id',
            'responsible_id' => 'nullable|integer|exists:users,id',
            'expected_date' => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required_with:items|uuid|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
        ];
    }
}

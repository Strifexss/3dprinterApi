<?php

namespace App\Http\Requests\BudgetItems;

use App\Http\Requests\AbstractRequest;

class StoreBudgetItemRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'budget_id' => 'required|uuid|exists:budgets,id',
            'product_id' => 'required|uuid|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ];
    }
}

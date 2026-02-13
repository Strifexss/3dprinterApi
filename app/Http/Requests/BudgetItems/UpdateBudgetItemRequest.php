<?php

namespace App\Http\Requests\BudgetItems;

use App\Http\Requests\AbstractRequest;

class UpdateBudgetItemRequest extends AbstractRequest
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
            'product_id' => 'sometimes|uuid|exists:products,id',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|numeric|min:0',
        ];
    }
}

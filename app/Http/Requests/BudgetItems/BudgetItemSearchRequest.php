<?php

namespace App\Http\Requests\BudgetItems;

use App\Http\Requests\AbstractRequest;

class BudgetItemSearchRequest extends AbstractRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'budget_id' => 'nullable|uuid',
            'product_id' => 'nullable|uuid',
        ];
    }
}

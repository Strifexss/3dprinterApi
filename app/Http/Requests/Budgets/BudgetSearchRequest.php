<?php
namespace App\Http\Requests\Budgets;

use App\Http\Requests\AbstractRequest;

class BudgetSearchRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            'client_id' => 'nullable|exists:clients,id',
            'status' => 'nullable|in:pending,approved,canceled',
        ];
    }
}

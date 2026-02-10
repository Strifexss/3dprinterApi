<?php
namespace App\Http\Requests\Budgets;

use App\Http\Requests\AbstractRequest;

class UpdateBudgetRequest extends AbstractRequest
{
    public function rules()
    {
        return [
            'status' => 'required|in:pending,approved,canceled',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'internal_note' => 'nullable|string',
            'price' => 'required|numeric',
        ];
    }
}

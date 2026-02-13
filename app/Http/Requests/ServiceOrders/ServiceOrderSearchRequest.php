<?php

namespace App\Http\Requests\ServiceOrders;

use App\Http\Requests\AbstractRequest;

class ServiceOrderSearchRequest extends AbstractRequest
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
            'client_id' => 'nullable|uuid',
            'printer_id' => 'nullable|integer',
            'responsible_id' => 'nullable|integer',
            'expected_date_from' => 'nullable|date',
            'expected_date_to' => 'nullable|date',
            'delivery_date_from' => 'nullable|date',
            'delivery_date_to' => 'nullable|date',
        ];
    }
}

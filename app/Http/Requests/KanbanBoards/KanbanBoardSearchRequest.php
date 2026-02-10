<?php

namespace App\Http\Requests\KanbanBoards;

use App\Http\Requests\AbstractRequest;

class KanbanBoardSearchRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tenant_id' => 'nullable|uuid',
            'printer_id' => 'nullable|integer',
            'from_status' => 'nullable|string',
            'to_status' => 'nullable|string',
            'changed_by_id' => 'nullable|integer',
            'changed_at' => 'nullable|date',
        ];
    }
}

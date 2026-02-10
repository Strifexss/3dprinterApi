<?php

namespace App\Http\Requests\KanbanBoards;

use App\Http\Requests\AbstractRequest;

class UpdateKanbanBoardRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tenant_id' => 'sometimes|uuid',
            'printer_id' => 'sometimes|integer|exists:printers,id',
            'from_status' => 'sometimes|string',
            'to_status' => 'sometimes|string',
            'changed_by_id' => 'sometimes|integer|exists:users,id',
            'changed_at' => 'sometimes|date',
            'notes' => 'nullable|string',
        ];
    }
}

<?php

namespace App\Http\Requests\KanbanBoards;

use App\Http\Requests\AbstractRequest;

class StoreKanbanBoardRequest extends AbstractRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|uuid',
            'tenant_id' => 'required|uuid',
            'printer_id' => 'required|integer|exists:printers,id',
            'from_status' => 'required|string',
            'to_status' => 'required|string',
            'changed_by_id' => 'required|integer|exists:users,id',
            'changed_at' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }
}

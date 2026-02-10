<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KanbanBoardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'printer_id' => $this->printer_id,
            'from_status' => $this->from_status,
            'to_status' => $this->to_status,
            'changed_by_id' => $this->changed_by_id,
            'changed_at' => $this->changed_at,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

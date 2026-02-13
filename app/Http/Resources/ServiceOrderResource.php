<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'budget_id' => $this->budget_id,
            'client_id' => $this->client_id,
            'description' => $this->description,
            'notes' => $this->notes,
            'printer_id' => $this->printer_id,
            'responsible_id' => $this->responsible_id,
            'expected_date' => $this->expected_date,
            'delivery_date' => $this->delivery_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'client' => $this->whenLoaded('client'),
            'printer' => $this->whenLoaded('printer'),
            'responsible' => $this->whenLoaded('responsible'),
            'budget' => $this->whenLoaded('budget'),
            'items' => ServiceOrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}

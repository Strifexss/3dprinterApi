<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'service_order_id' => $this->service_order_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'product' => $this->whenLoaded('product'),
            'service_order' => $this->whenLoaded('serviceOrder'),
        ];
    }
}

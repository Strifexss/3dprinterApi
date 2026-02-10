<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrinterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'model' => $this->model,
            'manufacturer' => $this->manufacturer,
            'serial_number' => $this->serial_number,
            'technology' => $this->technology,
            'acquisition_date' => $this->acquisition_date,
            'warranty_until' => $this->warranty_until,
            'status' => $this->status,
            'location' => $this->location,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

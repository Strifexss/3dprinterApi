<?php

namespace App\Dto\Products;

use App\Dto\DTO;

class ProductSearchDTO extends DTO
{
    public $tenant_id = null;
    public $group_id = null;
    public $sku = null;
    public $name = null;
    public $description = null;
    public $unit = null;
    public $color = null;
    public $material = null;
    public $min_stock = null;
    public $is_active = null;

    public function __construct(array $data = [])
    {
        $this->tenant_id   = $data['tenant_id']   ?? null;
        $this->group_id    = $data['group_id']    ?? null;
        $this->sku         = $data['sku']         ?? null;
        $this->name        = $data['name']        ?? null;
        $this->description = $data['description'] ?? null;
        $this->unit        = $data['unit']        ?? null;
        $this->color       = $data['color']       ?? null;
        $this->material    = $data['material']    ?? null;
        $this->min_stock   = $data['min_stock']   ?? null;
        $this->is_active   = $data['is_active']   ?? null;
    }
}

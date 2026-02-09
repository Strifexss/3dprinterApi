<?php

namespace App\Dto\Products;

class ProductStoreDTO
{
    public $group_id;
    public $tenant_id;
    public $sku;
    public $name;
    public $description;
    public $unit;
    public $color;
    public $material;
    public $min_stock;
    public $is_active;
    public $created_by;
    public $updated_by;

    public function __construct(array $data)
    {
        $this->group_id = $data['group_id'] ?? null;
        $this->tenant_id = $data['tenant_id'] ?? null;
        $this->sku = $data['sku'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->unit = $data['unit'] ?? null;
        $this->color = $data['color'] ?? null;
        $this->material = $data['material'] ?? null;
        $this->min_stock = $data['min_stock'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
        $this->created_by = $data['created_by'] ?? null;
        $this->updated_by = $data['updated_by'] ?? null;
    }
}

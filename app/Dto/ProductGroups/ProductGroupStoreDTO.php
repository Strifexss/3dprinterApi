<?php

namespace App\Dto\ProductGroups;

class ProductGroupStoreDTO
{
    public $tenant_id;
    public $name;
    public $description;
    public $is_active;
    public $created_by;
    public $updated_by;

    public function __construct(array $data)
    {
        $this->tenant_id = $data['tenant_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->is_active = $data['is_active'] ?? true;
        $this->created_by = $data['created_by'] ?? null;
        $this->updated_by = $data['updated_by'] ?? null;
    }
}

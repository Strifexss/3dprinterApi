<?php

namespace App\Dto\ProductGroups;

class ProductGroupSearchDTO
{
    public $tenant_id;
    public $name;

    public function __construct(array $data)
    {
        $this->tenant_id = $data['tenant_id'] ?? null;
        $this->name = $data['name'] ?? null;
    }
}

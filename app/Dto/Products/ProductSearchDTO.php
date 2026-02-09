<?php

namespace App\Dto\Products;

class ProductSearchDTO
{
    public $tenant_id;
    public $name;
    public $sku;
    public $group_id;

    public function __construct(array $data)
    {
        $this->tenant_id = $data['tenant_id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->sku = $data['sku'] ?? null;
        $this->group_id = $data['group_id'] ?? null;
    }
}

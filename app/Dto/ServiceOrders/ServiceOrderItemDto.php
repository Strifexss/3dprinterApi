<?php

namespace App\Dto\ServiceOrders;

use App\Dto\DTO;

class ServiceOrderItemDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $service_order_id = null;
    public ?string $product_id = null;
    public ?int $quantity = null;
}

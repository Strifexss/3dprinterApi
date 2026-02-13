<?php

namespace App\Dto\ServiceOrders;

use App\Dto\DTO;

class ServiceOrderDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $client_id = null;
    public ?string $description = null;
    public ?string $notes = null;
    public ?int $printer_id = null;
    public ?int $responsible_id = null;
    public ?string $expected_date = null;
    public ?string $delivery_date = null;
    public ?array $items = null;
}

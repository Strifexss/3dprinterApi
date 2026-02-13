<?php

namespace App\Dto\ServiceOrders;

use App\Dto\DTO;

class ServiceOrderSearchDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $client_id = null;
    public ?int $printer_id = null;
    public ?int $responsible_id = null;
    public ?string $expected_date_from = null;
    public ?string $expected_date_to = null;
    public ?string $delivery_date_from = null;
    public ?string $delivery_date_to = null;
}

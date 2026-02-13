<?php

namespace App\Dto\ItemReservations;

use App\Dto\DTO;

class ItemReservationSearchDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $product_id = null;
    public ?string $status = null;
}

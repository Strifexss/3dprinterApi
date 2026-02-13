<?php

namespace App\Dto\ItemReservations;

use App\Dto\DTO;

class ItemReservationDto extends DTO
{
    public ?string $id = null;
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $product_id = null;
    public ?int $quantity = null;
    public ?string $status = null;
    public ?string $reservation_date = null;
    public ?string $expire_date = null;
    public ?string $note = null;
    public ?string $created_at = null;
}

<?php

namespace App\Dto\Budgets;

use App\Dto\DTO;

class BudgetItemDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $product_id = null;
    public ?int $quantity = null;
    public ?float $price = null;
}

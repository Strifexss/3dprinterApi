<?php

namespace App\Dto\Budgets;

use App\Dto\DTO;

class BudgetItemSearchDto extends DTO
{
    public ?string $tenant_id = null;
    public ?string $budget_id = null;
    public ?string $product_id = null;
}

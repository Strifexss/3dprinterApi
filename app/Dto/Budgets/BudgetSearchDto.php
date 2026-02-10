<?php
namespace App\Dto\Budgets;

use App\Dto\DTO;

class BudgetSearchDto extends DTO
{
    public $tenant_id;
    public $client_id = null;
    public $status = null;
    public $created_at = null;
    public $updated_at = null;
}

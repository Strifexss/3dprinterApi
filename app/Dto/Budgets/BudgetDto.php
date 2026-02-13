<?php
namespace App\Dto\Budgets;

use App\Dto\DTO;

class BudgetDto extends DTO
{
    public $id = null;
    public $tenant_id;
    public $status;
    public $description;
    public $client_id;
    public $internal_note = null;
    public $price = null;
    public $created_at = null;
    public $updated_at = null;
    public $items = null;
}

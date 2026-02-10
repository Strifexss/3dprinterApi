<?php
namespace App\Services\interfaces;

use App\Dto\Budgets\BudgetDto;
use App\Dto\Budgets\BudgetSearchDto;

interface BudgetServiceInterface
{
    public function all(BudgetSearchDto $dto);
    public function find($id);
    public function create(BudgetDto $dto);
    public function update($id, BudgetDto $dto);
    public function delete($id);
}

<?php

namespace App\Services\interfaces;

use App\Dto\Budgets\BudgetItemDto;
use App\Dto\Budgets\BudgetItemSearchDto;

interface BudgetItemServiceInterface
{
    public function all(BudgetItemSearchDto $searchDto);
    public function find($id);
    public function create(BudgetItemDto $dto);
    public function update($id, BudgetItemDto $dto);
    public function delete($id): bool;
    public function insertItems(array $rows): void;
}

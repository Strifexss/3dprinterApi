<?php
namespace App\Repositories;

use App\Models\Budget;
use App\Dto\Budgets\BudgetDto;
use App\Dto\Budgets\BudgetSearchDto;
use App\Repositories\interfaces\BudgetRepositoryInterface;

class BudgetRepository implements BudgetRepositoryInterface
{
    public function all(BudgetSearchDto $dto)
    {
        $query = Budget::query();
        $query->where('tenant_id', $dto->tenant_id)
              ->orWhereNull('tenant_id');
        // Adicione outros filtros conforme necessário
        return $query->get();
    }

    public function find($id)
    {
        return Budget::findOrFail($id);
    }

    public function create(BudgetDto $dto)
    {
        return Budget::create($dto->toArray());
    }

    public function update($id, BudgetDto $dto)
    {
        $budget = Budget::findOrFail($id);
        $budget->update($dto->toArray());
        return $budget;
    }

    public function delete($id)
    {
        $budget = Budget::findOrFail($id);
        return $budget->delete();
    }
}

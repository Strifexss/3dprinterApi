   
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
        return $this->filter(Budget::query(), $dto);
    }

    public function filter($query, BudgetSearchDto $dto)
    {
        $query->where('tenant_id', $dto->tenant_id)
              ->orWhereNull('tenant_id');

        if (!empty($dto->client_id)) {
            $query->where('client_id', $dto->client_id);
        }
        if (!empty($dto->status)) {
            $query->where('status', $dto->status);
        }
        if (!empty($dto->created_at)) {
            $query->whereDate('created_at', $dto->created_at);
        }
        if (!empty($dto->updated_at)) {
            $query->whereDate('updated_at', $dto->updated_at);
        }

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

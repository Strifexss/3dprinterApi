<?php
namespace App\Services;

use App\Services\interfaces\BudgetServiceInterface;
use App\Repositories\interfaces\BudgetRepositoryInterface;
use App\Dto\Budgets\BudgetDto;
use App\Dto\Budgets\BudgetSearchDto;
use Illuminate\Support\Facades\DB;

class BudgetService implements BudgetServiceInterface
{
    public function __construct(private BudgetRepositoryInterface $repository) {}

    public function all(BudgetSearchDto $dto)
    {
        return $this->repository->all($dto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(BudgetDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->repository->create($dto);
        });
    }

    public function update($id, BudgetDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }
}

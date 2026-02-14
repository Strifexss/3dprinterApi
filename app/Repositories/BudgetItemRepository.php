<?php

namespace App\Repositories;

use App\Dto\Budgets\BudgetItemDto;
use App\Dto\Budgets\BudgetItemSearchDto;
use App\Models\BudgetItem;
use App\Repositories\interfaces\BudgetItemRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BudgetItemRepository implements BudgetItemRepositoryInterface
{
    public function __construct(
        private BudgetItem $model
    ) {}

    public function all(BudgetItemSearchDto $dto)
    {
        $query = $this->model->newQuery()->with(['product', 'budget']);

        if ($dto->tenant_id) {
            $query->where(function ($sub) use ($dto) {
                $sub->where('tenant_id', $dto->tenant_id)
                    ->orWhereNull('tenant_id');
            });
        }
        if ($dto->budget_id) {
            $query->where('budget_id', $dto->budget_id);
        }
        if ($dto->product_id) {
            $query->where('product_id', $dto->product_id);
        }

        return $query->get();
    }

    public function find($id)
    {
        return $this->model->with(['product', 'budget'])->find($id);
    }

    public function create(BudgetItemDto $dto)
    {
        return $this->model->create([
            'id' => Str::uuid(),
            'tenant_id' => $dto->tenant_id,
            'budget_id' => $dto->budget_id,
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity ?? 1,
            'price' => $dto->price ?? 0,
        ]);
    }

    public function update($id, BudgetItemDto $dto)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return null;
        }
        $item->update([
            'tenant_id' => $dto->tenant_id ?? $item->tenant_id,
            'budget_id' => $dto->budget_id ?? $item->budget_id,
            'product_id' => $dto->product_id ?? $item->product_id,
            'quantity' => $dto->quantity ?? $item->quantity,
            'price' => $dto->price ?? $item->price,
        ]);
        return $item;
    }

    public function delete($id): bool
    {
        $item = $this->model->find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }

    public function insertItems(array $rows): void
    {
        if (empty($rows)) {
            return;
        }

        $this->model->insert($rows);
    }
}

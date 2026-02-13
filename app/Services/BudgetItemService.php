<?php

namespace App\Services;

use App\Dto\Budgets\BudgetItemDto;
use App\Dto\Budgets\BudgetItemSearchDto;
use App\Repositories\interfaces\BudgetItemRepositoryInterface;
use App\Services\interfaces\BudgetItemServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Services\interfaces\ItemReservationServiceInterface;

class BudgetItemService implements BudgetItemServiceInterface
{
    public function __construct(
        private BudgetItemRepositoryInterface $repository,
        private ?ItemReservationServiceInterface $reservationService = null
    ) {}

    public function all(BudgetItemSearchDto $searchDto)
    {
        return $this->repository->all($searchDto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(BudgetItemDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            $item = $this->repository->create($dto);
            // Create reservation if reservationService is available
            if ($this->reservationService) {
                $this->reservationService->create([
                    'tenant_id' => $dto->tenant_id,
                    'budget_id' => $dto->budget_id,
                    'product_id' => $dto->product_id,
                    'quantity' => $dto->quantity ?? 1,
                    'status' => 'active',
                    'reservation_date' => now(),
                ]);
            }
            return $item->load(['product', 'budget']);
        });
    }

    public function update($id, BudgetItemDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            $item = $this->repository->update($id, $dto);
            if (!$item) {
                return null;
            }
            return $item->load(['product', 'budget']);
        });
    }

    public function delete($id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }

    public function insertItems(array $rows): void
    {
        $this->repository->insertItems($rows);
        // Bulk reservation insert if reservationService is available
        if ($this->reservationService) {
            $reservationRows = array_map(function ($itemRow) {
                return [
                    'tenant_id' => $itemRow['tenant_id'],
                    'budget_id' => $itemRow['budget_id'],
                    'product_id' => $itemRow['product_id'],
                    'quantity' => $itemRow['quantity'],
                    'status' => 'active',
                    'reservation_date' => $itemRow['created_at'] ?? now(),
                ];
            }, $rows);
            $this->reservationService->insertItems($reservationRows);
        }
    }
}

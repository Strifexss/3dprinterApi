<?php
namespace App\Services;

use App\Services\interfaces\BudgetServiceInterface;
use App\Repositories\interfaces\BudgetRepositoryInterface;
use App\Services\interfaces\BudgetItemServiceInterface;
use App\Dto\Budgets\BudgetDto;
use App\Dto\Budgets\BudgetSearchDto;
use App\Services\interfaces\ItemReservationServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BudgetService implements BudgetServiceInterface
{
    public function __construct(
        private BudgetRepositoryInterface $repository,
        private BudgetItemServiceInterface $itemService,
        private ItemReservationServiceInterface $reservationService
    ) {}

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
            $budget = $this->repository->create($dto);
            $this->createItems($dto, $budget);
            return $budget;
        });
    }

    private function createItems(BudgetDto $dto, $budget): void
    {
        if (is_array($dto->items) && $dto->items && $budget) {
            $now = now();
            $itemRows = [];
            $reservationRows = [];

            foreach ($dto->items as $item) {
                $itemData = is_array($item) ? $item : [];

                if (empty($itemData['product_id'])) {
                    throw new \InvalidArgumentException('product_id is required for budget items.');
                }

                $itemRow = [
                    'id' => (string) Str::uuid(),
                    'tenant_id' => $budget->tenant_id,
                    'budget_id' => $budget->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'] ?? 1,
                    'price' => $itemData['price'] ?? 0,
                    'created_at' => $now,
                ];
                $itemRows[] = $itemRow;
                
                $reservationRows[] = [
                    'tenant_id' => $itemRow['tenant_id'],
                    'budget_id' => $itemRow['budget_id'],
                    'product_id' => $itemRow['product_id'],
                    'quantity' => $itemRow['quantity'],
                    'status' => 'active',
                    'reservation_date' => $now,
                ];
            }

            $this->itemService->insertItems($itemRows);
            $this->reservationService->insertItems($reservationRows);
        }
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

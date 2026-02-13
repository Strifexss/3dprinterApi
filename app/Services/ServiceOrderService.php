<?php

namespace App\Services;

use App\Dto\ServiceOrders\ServiceOrderDto;
use App\Dto\ServiceOrders\ServiceOrderSearchDto;
use App\Repositories\interfaces\ServiceOrderRepositoryInterface;
use App\Services\interfaces\ServiceOrderItemServiceInterface;
use App\Services\interfaces\ServiceOrderServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceOrderService implements ServiceOrderServiceInterface
{
    public function __construct(
        private ServiceOrderRepositoryInterface $repository,
        private ServiceOrderItemServiceInterface $itemService
    ) {}

    public function all(ServiceOrderSearchDto $searchDto)
    {
        return $this->repository->all($searchDto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(ServiceOrderDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            $order = $this->repository->create($dto);
            $this->createItems($dto, $order);
            
            return $order;
        });
    }

    private function createItems(ServiceOrderDto $dto, $order)
    {
        if (is_array($dto->items) && $dto->items && $order) {
            $rows = $this->normalizeItems($dto, $order->id, $order->tenant_id);
            $this->itemService->insertItems($rows);
        }
    }

    private function normalizeItems(ServiceOrderDto $dto, string $serviceOrderId, string $tenantId): array
    {
        $now = now();
        $rows = [];

        foreach ($dto->items as $item) {
            $itemData = is_array($item) ? $item : [];

            if (empty($itemData['product_id'])) {
                throw new \InvalidArgumentException('product_id is required for service order items.');
            }

            $rows[] = [
                'id' => (string) Str::uuid(),
                'tenant_id' => $tenantId,
                'service_order_id' => $serviceOrderId,
                'product_id' => $itemData['product_id'],
                'quantity' => $itemData['quantity'] ?? 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        return $rows;
    }

    public function update($id, ServiceOrderDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            $order = $this->repository->update($id, $dto);
            if (!$order) {
                return null;
            }
            if (is_array($dto->items)) {
                $this->repository->replaceItems($order->id, $order->tenant_id, $dto->items);
            }
            return $order->load(['items.product', 'client', 'printer', 'responsible', 'budget']);
        });
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }
}

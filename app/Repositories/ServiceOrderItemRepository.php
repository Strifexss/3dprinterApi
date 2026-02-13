<?php

namespace App\Repositories;

use App\Dto\ServiceOrders\ServiceOrderItemDto;
use App\Dto\ServiceOrders\ServiceOrderItemSearchDto;
use App\Models\ServiceOrderItem;
use App\Repositories\interfaces\ServiceOrderItemRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceOrderItemRepository implements ServiceOrderItemRepositoryInterface
{
    public function __construct(
        private ServiceOrderItem $model
    ) {}

    public function all(ServiceOrderItemSearchDto $dto)
    {
        $query = $this->model->newQuery()->with(['product', 'serviceOrder']);

        if ($dto->tenant_id) {
            $query->where(function ($sub) use ($dto) {
                $sub->where('tenant_id', $dto->tenant_id)
                    ->orWhereNull('tenant_id');
            });
        }
        if ($dto->service_order_id) {
            $query->where('service_order_id', $dto->service_order_id);
        }
        if ($dto->product_id) {
            $query->where('product_id', $dto->product_id);
        }

        return $query->get();
    }

    public function find($id)
    {
        return $this->model->with(['product', 'serviceOrder'])->find($id);
    }

    public function create(ServiceOrderItemDto $dto)
    {
        return $this->model->create([
            'id' => Str::uuid(),
            'tenant_id' => $dto->tenant_id,
            'service_order_id' => $dto->service_order_id,
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity ?? 1,
        ]);
    }

    public function update($id, ServiceOrderItemDto $dto)
    {
        $item = $this->model->find($id);
        if (!$item) {
            return null;
        }
        $item->update([
            'tenant_id' => $dto->tenant_id ?? $item->tenant_id,
            'service_order_id' => $dto->service_order_id ?? $item->service_order_id,
            'product_id' => $dto->product_id ?? $item->product_id,
            'quantity' => $dto->quantity ?? $item->quantity,
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

        DB::table('service_order_items')->insert($rows);
    }
}

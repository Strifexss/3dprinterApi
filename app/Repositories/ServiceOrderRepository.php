<?php

namespace App\Repositories;

use App\Dto\ServiceOrders\ServiceOrderDto;
use App\Dto\ServiceOrders\ServiceOrderItemDto;
use App\Dto\ServiceOrders\ServiceOrderSearchDto;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderItem;
use App\Repositories\interfaces\ServiceOrderRepositoryInterface;
use Illuminate\Support\Str;

class ServiceOrderRepository implements ServiceOrderRepositoryInterface
{
    public function __construct(
        private ServiceOrder $model,
        private ServiceOrderItem $itemModel
    ) {}

    public function all(ServiceOrderSearchDto $dto)
    {
        $query = $this->model->newQuery()->with([
            'items.product',
            'client',
            'printer',
            'responsible',
            'budget',
        ]);

        if ($dto->tenant_id) {
            $query->where(function ($sub) use ($dto) {
                $sub->where('tenant_id', $dto->tenant_id)
                    ->orWhereNull('tenant_id');
            });
        }
        if ($dto->budget_id) {
            $query->where('budget_id', $dto->budget_id);
        }
        if ($dto->client_id) {
            $query->where('client_id', $dto->client_id);
        }
        if ($dto->printer_id) {
            $query->where('printer_id', $dto->printer_id);
        }
        if ($dto->responsible_id) {
            $query->where('responsible_id', $dto->responsible_id);
        }
        if ($dto->expected_date_from) {
            $query->where('expected_date', '>=', $dto->expected_date_from);
        }
        if ($dto->expected_date_to) {
            $query->where('expected_date', '<=', $dto->expected_date_to);
        }
        if ($dto->delivery_date_from) {
            $query->where('delivery_date', '>=', $dto->delivery_date_from);
        }
        if ($dto->delivery_date_to) {
            $query->where('delivery_date', '<=', $dto->delivery_date_to);
        }

        return $query->get();
    }

    public function find($id)
    {
        return $this->model->with([
            'items.product',
            'client',
            'printer',
            'responsible',
            'budget',
        ])->find($id);
    }

    public function create(ServiceOrderDto $dto)
    {
        return $this->model->create([
            'id' => Str::uuid(),
            'tenant_id' => $dto->tenant_id,
            'budget_id' => $dto->budget_id,
            'client_id' => $dto->client_id,
            'description' => $dto->description,
            'notes' => $dto->notes,
            'printer_id' => $dto->printer_id,
            'responsible_id' => $dto->responsible_id,
            'expected_date' => $dto->expected_date,
            'delivery_date' => $dto->delivery_date,
        ]);
    }

    public function update($id, ServiceOrderDto $dto)
    {
        $order = $this->model->find($id);
        if (!$order) {
            return null;
        }
        $order->update([
            'tenant_id' => $dto->tenant_id,
            'budget_id' => $dto->budget_id,
            'client_id' => $dto->client_id,
            'description' => $dto->description,
            'notes' => $dto->notes,
            'printer_id' => $dto->printer_id,
            'responsible_id' => $dto->responsible_id,
            'expected_date' => $dto->expected_date,
            'delivery_date' => $dto->delivery_date,
        ]);
        return $order;
    }

    public function delete($id): bool
    {
        $order = $this->model->find($id);
        if ($order) {
            $order->delete();
            return true;
        }
        return false;
    }

    public function replaceItems(string $serviceOrderId, string $tenantId, array $items): void
    {
        $this->itemModel->where('service_order_id', $serviceOrderId)->delete();

        foreach ($items as $item) {
            $itemDto = $item instanceof ServiceOrderItemDto ? $item : new ServiceOrderItemDto($item);
            $this->itemModel->create([
                'id' => Str::uuid(),
                'tenant_id' => $tenantId,
                'service_order_id' => $serviceOrderId,
                'product_id' => $itemDto->product_id,
                'quantity' => $itemDto->quantity ?? 1,
            ]);
        }
    }
}

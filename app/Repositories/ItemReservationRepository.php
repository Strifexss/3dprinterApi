<?php

namespace App\Repositories;

use App\Models\ItemReservation;
use App\Repositories\interfaces\ItemReservationRepositoryInterface;
use App\Dto\ItemReservations\ItemReservationDto;
use App\Dto\ItemReservations\ItemReservationSearchDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemReservationRepository implements ItemReservationRepositoryInterface
{
    public function __construct(private ItemReservation $model) {}

    public function all(ItemReservationSearchDto $dto)
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
        if ($dto->status) {
            $query->where('status', $dto->status);
        }

        return $query->get();
    }

    public function find($id)
    {
        return $this->model->with(['product', 'budget'])->find($id);
    }

    public function create(ItemReservationDto $dto)
    {
        return $this->model->create([
            'id' => $dto->id ?? (string) Str::uuid(),
            'tenant_id' => $dto->tenant_id,
            'budget_id' => $dto->budget_id,
            'product_id' => $dto->product_id,
            'quantity' => $dto->quantity ?? 1,
            'status' => $dto->status ?? 'active',
            'reservation_date' => $dto->reservation_date ?? now(),
            'expire_date' => $dto->expire_date,
            'note' => $dto->note,
        ]);
    }

    public function update($id, ItemReservationDto $dto)
    {
        $reservation = $this->model->find($id);
        if (!$reservation) {
            return null;
        }
        $reservation->update([
            'tenant_id' => $dto->tenant_id ?? $reservation->tenant_id,
            'budget_id' => $dto->budget_id ?? $reservation->budget_id,
            'product_id' => $dto->product_id ?? $reservation->product_id,
            'quantity' => $dto->quantity ?? $reservation->quantity,
            'status' => $dto->status ?? $reservation->status,
            'reservation_date' => $dto->reservation_date ?? $reservation->reservation_date,
            'expire_date' => $dto->expire_date ?? $reservation->expire_date,
            'note' => $dto->note ?? $reservation->note,
        ]);
        return $reservation;
    }

    public function delete($id): bool
    {
        $reservation = $this->model->find($id);
        if ($reservation) {
            $reservation->delete();
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

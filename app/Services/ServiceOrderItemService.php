<?php

namespace App\Services;

use App\Dto\ServiceOrders\ServiceOrderItemDto;
use App\Dto\ServiceOrders\ServiceOrderItemSearchDto;
use App\Repositories\interfaces\ServiceOrderItemRepositoryInterface;
use App\Services\interfaces\ServiceOrderItemServiceInterface;
use Illuminate\Support\Facades\DB;

class ServiceOrderItemService implements ServiceOrderItemServiceInterface
{
    public function __construct(
        private ServiceOrderItemRepositoryInterface $repository,
    ) {}

    public function all(ServiceOrderItemSearchDto $searchDto)
    {
        return $this->repository->all($searchDto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(ServiceOrderItemDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            $item = $this->repository->create($dto);
            return $item->load(['product', 'serviceOrder']);
        });
    }

    public function update($id, ServiceOrderItemDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            $item = $this->repository->update($id, $dto);
            if (!$item) {
                return null;
            }
            return $item->load(['product', 'serviceOrder']);
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
    }
}

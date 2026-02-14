<?php

namespace App\Services;

use App\Dto\ItemReservations\ItemReservationDto;
use App\Dto\ItemReservations\ItemReservationSearchDto;
use App\Repositories\interfaces\ItemReservationRepositoryInterface;
use App\Services\interfaces\ItemReservationServiceInterface;

class ItemReservationService implements ItemReservationServiceInterface
{
    public function __construct(private ItemReservationRepositoryInterface $repository) {}

    public function all(ItemReservationSearchDto $dto)
    {
        return $this->repository->all($dto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(ItemReservationDto $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, ItemReservationDto $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->repository->delete($id);
    }

    public function insertItems(array $rows): void
    {
        $this->repository->insertItems($rows);
    }
}

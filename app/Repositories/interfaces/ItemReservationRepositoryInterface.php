<?php

namespace App\Repositories\interfaces;

use App\Dto\ItemReservations\ItemReservationSearchDto;
use App\Dto\ItemReservations\ItemReservationDto;

interface ItemReservationRepositoryInterface
{
    public function all(ItemReservationSearchDto $dto);
    public function find($id);
    public function create(ItemReservationDto $dto);
    public function update($id, ItemReservationDto $dto);
    public function delete($id): bool;
    public function insertItems(array $rows): void;
}

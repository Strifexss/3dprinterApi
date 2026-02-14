<?php

namespace App\Services\interfaces;

use App\Dto\ItemReservations\ItemReservationDto;
use App\Dto\ItemReservations\ItemReservationSearchDto;

interface ItemReservationServiceInterface
{
    public function all(ItemReservationSearchDto $dto);
    public function find($id);
    public function create(ItemReservationDto $data);
    public function update($id, ItemReservationDto $data);
    public function delete($id): bool;
    public function insertItems(array $rows): void;
}

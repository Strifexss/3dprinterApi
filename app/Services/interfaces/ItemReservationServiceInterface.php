<?php

namespace App\Services\interfaces;

interface ItemReservationServiceInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id): bool;
    public function insertItems(array $rows): void;
}

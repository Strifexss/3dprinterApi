<?php

namespace App\Services\interfaces;

use App\Dto\ServiceOrders\ServiceOrderDto;
use App\Dto\ServiceOrders\ServiceOrderSearchDto;

interface ServiceOrderServiceInterface
{
    public function all(ServiceOrderSearchDto $searchDto);
    public function find($id);
    public function create(ServiceOrderDto $dto);
    public function update($id, ServiceOrderDto $dto);
    public function delete($id): bool;
}

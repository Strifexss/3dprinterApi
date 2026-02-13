<?php

namespace App\Services\interfaces;

use App\Dto\ServiceOrders\ServiceOrderItemDto;
use App\Dto\ServiceOrders\ServiceOrderItemSearchDto;

interface ServiceOrderItemServiceInterface
{
    public function all(ServiceOrderItemSearchDto $searchDto);
    public function find($id);
    public function create(ServiceOrderItemDto $dto);
    public function update($id, ServiceOrderItemDto $dto);
    public function delete($id): bool;
    public function insertItems(array $rows): void;
}

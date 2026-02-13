<?php

namespace App\Repositories\interfaces;

use App\Dto\ServiceOrders\ServiceOrderDto;
use App\Dto\ServiceOrders\ServiceOrderSearchDto;

interface ServiceOrderRepositoryInterface
{
    public function all(ServiceOrderSearchDto $dto);
    public function find($id);
    public function create(ServiceOrderDto $dto);
    public function update($id, ServiceOrderDto $dto);
    public function delete($id): bool;
    public function replaceItems(string $serviceOrderId, string $tenantId, array $items): void;
}

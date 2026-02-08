<?php

namespace App\Repositories\interfaces;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;

interface ClientRepositoryInterface
{
    public function all(ClientSearchDTO $dto);
    public function store(ClientStoreDTO $clientStoreDTO);
    public function findById($id);
    public function destroy($id): bool;
}

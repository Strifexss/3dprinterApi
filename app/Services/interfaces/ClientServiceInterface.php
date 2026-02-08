<?php

namespace App\Services\interfaces;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;

interface ClientServiceInterface
{
    public function all(ClientSearchDTO $searchDTO);
    public function store(ClientStoreDTO $clientStoreDTO);
    public function destroy($id): bool;
    public function findById($id);
}

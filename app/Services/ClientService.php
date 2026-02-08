<?php

namespace App\Services;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Services\interfaces\ClientServiceInterface;
use App\Repositories\interfaces\ClientRepositoryInterface;

class ClientService implements ClientServiceInterface
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function all(ClientSearchDTO $searchDTO)
    {   
        return $this->clientRepository->all($searchDTO);
    }

    public function store(ClientStoreDTO $clientStoreDTO)
    {
        return $this->clientRepository->store($clientStoreDTO);
    }

    public function destroy($id): bool
    {
        return $this->clientRepository->destroy($id);
    }

    public function findById($id)
    {
        return $this->clientRepository->findById($id);
    }
}

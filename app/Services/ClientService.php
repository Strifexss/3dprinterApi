<?php

namespace App\Services;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Services\interfaces\ClientServiceInterface;
use App\Repositories\interfaces\ClientRepositoryInterface;
use App\Services\interfaces\ContactServiceInterface;
use Illuminate\Support\Facades\DB;

class ClientService implements ClientServiceInterface
{
    protected $clientRepository;
    protected $contactService;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ContactServiceInterface $contactService
    ) {
        $this->clientRepository = $clientRepository;
        $this->contactService = $contactService;
    }

    public function all(ClientSearchDTO $searchDTO)
    {   
        return $this->clientRepository->all($searchDTO);
    }

    public function store(ClientStoreDTO $clientStoreDTO)
    {
        return DB::transaction(function () use ($clientStoreDTO) {
            $client = $this->clientRepository->store($clientStoreDTO);
            $this->syncContacts($client, $clientStoreDTO);
            return $client;
        });
    }

    private function syncContacts($client, ClientStoreDTO $dto): void
    {
        if (empty($dto->contatos) || !is_array($dto->contatos)) {
            return;
        }
        $this->contactService->createForClient($client->id, $dto->contatos);
    }

    public function destroy($id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->clientRepository->destroy($id);
        });
    }

    public function findById($id)
    {
        return $this->clientRepository->findById($id);
    }
}

<?php

namespace App\Services;

use App\Repositories\ContactRepository;

class ContactService implements \App\Services\interfaces\ContactServiceInterface
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function createContact(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function getContactsByClient($clientId)
    {
        return $this->contactRepository->findByClientId($clientId);
    }

    public function createForClient(string $clientId, array $contatos): void
    {
        foreach ($contatos as $contato) {
            $contato['client_id'] = $clientId;
            $this->createContact($contato);
        }
    }
}

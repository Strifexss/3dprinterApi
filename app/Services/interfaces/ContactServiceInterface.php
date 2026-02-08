<?php

namespace App\Services\interfaces;

interface ContactServiceInterface
{
    public function createContact(array $data);
    public function getContactsByClient($clientId);
    public function createForClient(string $clientId, array $contatos): void;
}

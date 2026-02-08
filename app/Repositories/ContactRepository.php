<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository implements \App\Repositories\interfaces\ContactRepositoryInterface
{
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function findByClientId($clientId)
    {
        return Contact::where('client_id', $clientId)->get();
    }
}

<?php

namespace App\Repositories\interfaces;

interface ContactRepositoryInterface
{
    public function create(array $data);
    public function findByClientId($clientId);
}

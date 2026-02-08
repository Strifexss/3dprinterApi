<?php

namespace App\Dto\Clients;

use App\Dto\DTO;

class ClientSearchDTO extends DTO
{
    public ?string $tenant_id = null;
    public ?string $nome = null;
    public ?string $cpf_cnpj = null;
    public ?string $tipo_pessoa = null;
}

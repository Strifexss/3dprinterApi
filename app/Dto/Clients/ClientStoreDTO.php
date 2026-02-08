<?php

namespace App\Dto\Clients;

use App\Dto\DTO;

class ClientStoreDTO extends DTO
{
    public ?string $tenant_id = null;
    public string $nome;
    public ?string $razao_social = null;
    public string $cpf_cnpj;
    public string $tipo_pessoa;
    public ?array $extras = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $fulltext_nome = null;
}

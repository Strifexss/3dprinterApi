<?php

namespace App\Repositories;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Models\Client;
use App\Repositories\interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private Client $model
    ){}

    public function all(ClientSearchDTO $dto)
    {
        $query = $this->model->newQuery()
            ->with(['contacts' => function($q) {
                $q->where('tipo', 'PRINCIPAL');
            }]);

        return $this->filter($dto, $query)->get();
    }

    private function filter(ClientSearchDTO $dto, $query)
    {
        if ($dto->tenant_id) {
            $query->where('tenant_id', $dto->tenant_id);
        }
        if ($dto->nome) {
            $query->where('nome', 'ilike', "%{$dto->nome}%");
        }
        if ($dto->cpf_cnpj) {
            $query->where('cpf_cnpj', $dto->cpf_cnpj);
        }
        if ($dto->tipo_pessoa) {
            $query->where('tipo_pessoa', $dto->tipo_pessoa);
        }
        return $query;
    }

    public function store(ClientStoreDTO $clientStoreDTO)
    {
        $client = $this->model->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'tenant_id' => $clientStoreDTO->tenant_id,
            'nome' => $clientStoreDTO->nome,
            'razao_social' => $clientStoreDTO->razao_social,
            'cpf_cnpj' => $clientStoreDTO->cpf_cnpj,
            'tipo_pessoa' => $clientStoreDTO->tipo_pessoa,
            'extras' => $clientStoreDTO->extras,
            'created_by' => $clientStoreDTO->created_by,
            'updated_by' => $clientStoreDTO->updated_by,
            'fulltext_nome' => $clientStoreDTO->fulltext_nome,
        ]);
        return $client;
    }

    public function findById($id)
    {
        return $this->model->with('contacts')->find($id);
    }

    public function destroy($id): bool
    {
        $client = $this->model->find($id);
        if ($client) {
            $client->delete();
            return true;
        }
        return false;
    }
}

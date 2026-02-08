<?php

namespace App\Repositories;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Models\Client;
use App\Repositories\interfaces\ClientRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ClientRepository implements ClientRepositoryInterface
{
    public function __construct(
        private Client $model
    ){}

    public function all(ClientSearchDTO $dto)
    {
        try {
            $query = $this->model->newQuery();
            $query = $this->filter($dto, $query);
            return $query->get();
        } catch (\Exception $e) {
            throw $e;
        }
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
        return DB::transaction(function () use ($clientStoreDTO) {
            return $this->model->create([
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
        });
    }

    public function findById($id)
    {
        return $this->model->find($id);
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

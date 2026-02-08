<?php

namespace App\Http\Controllers;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Services\interfaces\ClientServiceInterface;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    public function __construct(
        private ClientServiceInterface $clientService
    ) {}

    public function index(Request $request)
    {
        try {
            $clients = $this->clientService->all(new ClientSearchDTO($request->all()));
            return response()->json(ClientResource::collection($clients), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar clientes.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = $this->clientService->findById($id);
            if ($client) {
                return response()->json(new ClientResource($client), 200);
            }
            return response()->json(['error' => 'Cliente não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar cliente.'], 500);
        }
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $client = $this->clientService->store(new ClientStoreDTO($request->validated()));
            return response()->json(new ClientResource($client), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o cliente.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->clientService->destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Cliente removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Cliente não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover o cliente.'], 500);
        }
    }
}

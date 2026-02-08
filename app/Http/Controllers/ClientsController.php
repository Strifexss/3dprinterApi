<?php

namespace App\Http\Controllers;

use App\Dto\Clients\ClientSearchDTO;
use App\Dto\Clients\ClientStoreDTO;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Services\interfaces\ClientServiceInterface;
use App\Http\Resources\ClientResource;

class ClientsController extends Controller
{
    public function __construct(
        private ClientServiceInterface $clientService
    ) {}

    public function index(Request $request)
    {
        try {
            $data = $request->all();
            if ($request->user() && isset($request->user()->tenant_id)) {
                $data['tenant_id'] = $request->user()->tenant_id;
            }
            $dto = new ClientSearchDTO($data);
            $clients = $this->clientService->all($dto);
            return response()->json(ClientResource::collection($clients), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $client = $this->clientService->findById($id);
            if ($client) {
                return response()->json(new ClientResource($client), 200);
            }
            return response()->json(['error' => 'Client not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $client = $this->clientService->store(new ClientStoreDTO($request->validated()));
            return response()->json(new ClientResource($client), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->clientService->destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Client deleted'], 200);
            }
            return response()->json(['error' => 'Client not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

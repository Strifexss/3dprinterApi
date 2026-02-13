<?php

namespace App\Http\Controllers;

use App\Dto\ServiceOrders\ServiceOrderItemDto;
use App\Dto\ServiceOrders\ServiceOrderItemSearchDto;
use App\Http\Requests\ServiceOrderItems\ServiceOrderItemSearchRequest;
use App\Http\Requests\ServiceOrderItems\StoreServiceOrderItemRequest;
use App\Http\Requests\ServiceOrderItems\UpdateServiceOrderItemRequest;
use App\Http\Resources\ServiceOrderItemResource;
use App\Services\interfaces\ServiceOrderItemServiceInterface;

class ServiceOrderItemsController extends Controller
{
    public function __construct(
        private ServiceOrderItemServiceInterface $service
    ) {}

    public function index(ServiceOrderItemSearchRequest $request)
    {
        try {
            $items = $this->service->all(new ServiceOrderItemSearchDto($request->validated()));
            return response()->json(ServiceOrderItemResource::collection($items), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar itens de ordem de servico.'], 500);
        }
    }

    public function show($id)
    {
        try {
            if ($item = $this->service->find($id)) {
                return response()->json(new ServiceOrderItemResource($item), 200);
            }
            return response()->json(['error' => 'Item de ordem de servico nao encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar item de ordem de servico.'], 500);
        }
    }

    public function store(StoreServiceOrderItemRequest $request)
    {
        try {
            $created = $this->service->create(new ServiceOrderItemDto($request->validated()));
            return response()->json(new ServiceOrderItemResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar item de ordem de servico.'], 500);
        }
    }

    public function update(UpdateServiceOrderItemRequest $request, $id)
    {
        try {
            if ($updated = $this->service->update($id, new ServiceOrderItemDto($request->validated()))) {
                return response()->json(new ServiceOrderItemResource($updated), 200);
            }
            return response()->json(['error' => 'Item de ordem de servico nao encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar item de ordem de servico.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->service->delete($id)) {
                return response()->json(['message' => 'Item de ordem de servico removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Item de ordem de servico nao encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover item de ordem de servico.'], 500);
        }
    }
}

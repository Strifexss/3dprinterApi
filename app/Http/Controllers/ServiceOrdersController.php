<?php

namespace App\Http\Controllers;

use App\Dto\ServiceOrders\ServiceOrderDto;
use App\Dto\ServiceOrders\ServiceOrderSearchDto;
use App\Http\Requests\ServiceOrders\ServiceOrderSearchRequest;
use App\Http\Requests\ServiceOrders\StoreServiceOrderRequest;
use App\Http\Requests\ServiceOrders\UpdateServiceOrderRequest;
use App\Http\Resources\ServiceOrderResource;
use App\Services\interfaces\ServiceOrderServiceInterface;

class ServiceOrdersController extends Controller
{
    public function __construct(
        private ServiceOrderServiceInterface $service
    ) {}

    public function index(ServiceOrderSearchRequest $request)
    {
        try {
            $orders = $this->service->all(new ServiceOrderSearchDto($request->validated()));
            return response()->json(ServiceOrderResource::collection($orders), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar ordens de servico.'], 500);
        }
    }

    public function show($id)
    {
        try {
            if ($order = $this->service->find($id)) {
                return response()->json(new ServiceOrderResource($order), 200);
            }
            return response()->json(['error' => 'Ordem de servico nao encontrada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar ordem de servico.'], 500);
        }
    }

    public function store(StoreServiceOrderRequest $request)
    {
        try {
            $created = $this->service->create(new ServiceOrderDto($request->validated()));
            return response()->json(new ServiceOrderResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar ordem de servico.'], 500);
        }
    }

    public function update(UpdateServiceOrderRequest $request, $id)
    {
        try {
            if ($updated = $this->service->update($id, new ServiceOrderDto($request->validated()))) {
                return response()->json(new ServiceOrderResource($updated), 200);
            }
            return response()->json(['error' => 'Ordem de servico nao encontrada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar ordem de servico.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->service->delete($id)) {
                return response()->json(['message' => 'Ordem de servico removida com sucesso.'], 200);
            }
            return response()->json(['error' => 'Ordem de servico nao encontrada.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover ordem de servico.'], 500);
        }
    }
}

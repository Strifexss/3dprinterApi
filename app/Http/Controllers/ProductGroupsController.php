<?php

namespace App\Http\Controllers;

use App\Dto\ProductGroups\ProductGroupSearchDTO;
use App\Dto\ProductGroups\ProductGroupStoreDTO;
use App\Http\Requests\ProductGroupSearchRequest;
use App\Services\interfaces\ProductGroupServiceInterface;
use App\Http\Resources\ProductGroupResource;

class ProductGroupsController extends Controller
{
    public function __construct(
        private ProductGroupServiceInterface $productGroupService
    ) {}

    public function index(ProductGroupSearchRequest $request)
    {
        try {
                $groups = $this->productGroupService->all(new ProductGroupSearchDTO($request->validated()));
            return response()->json(ProductGroupResource::collection($groups), 200);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['error' => 'Erro ao buscar grupos.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $group = $this->productGroupService->findById($id);
            if ($group) {
                return response()->json(new ProductGroupResource($group), 200);
            }
            return response()->json(['error' => 'Grupo não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar grupo.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $group = $this->productGroupService->store(new ProductGroupStoreDTO($request->all()));
            return response()->json(new ProductGroupResource($group), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o grupo.'], 500);
        }
    }

      public function update(Request $request, $id)
    {
        try {
            $group = $this->productGroupService->update($id, new ProductGroupStoreDTO($request->all()));
            if ($group) {
                return response()->json(new ProductGroupResource($group), 200);
            }
            return response()->json(['error' => 'Grupo não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o grupo.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->productGroupService->destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Grupo removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Grupo não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover o grupo.'], 500);
        }
    }
}

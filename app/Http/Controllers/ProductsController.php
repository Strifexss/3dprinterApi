<?php

namespace App\Http\Controllers;

use App\Dto\Products\ProductSearchDTO;
use App\Dto\Products\ProductStoreDTO;
use Illuminate\Http\Request;
use App\Services\interfaces\ProductServiceInterface;
use App\Http\Resources\ProductResource;

class ProductsController extends Controller
{
    public function __construct(
        private ProductServiceInterface $productService
    ) {}



    public function index(Request $request)
    {
        try {
            $products = $this->productService->all(new ProductSearchDTO($request->all()));
            return response()->json(ProductResource::collection($products), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar produtos.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->findById($id);
            if ($product) {
                return response()->json(new ProductResource($product), 200);
            }
            return response()->json(['error' => 'Produto não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar produto.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $product = $this->productService->store(new ProductStoreDTO($request->all()));
            return response()->json(new ProductResource($product), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o produto.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = $this->productService->update($id, new ProductStoreDTO($request->all()));
            if ($product) {
                return response()->json(new ProductResource($product), 200);
            }
            return response()->json(['error' => 'Produto não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar o produto.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->productService->destroy($id);
            if ($deleted) {
                return response()->json(['message' => 'Produto removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Produto não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover o produto.'], 500);
        }
    }
}

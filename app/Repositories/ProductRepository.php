<?php

namespace App\Repositories;

use App\Dto\Products\ProductSearchDTO;
use App\Dto\Products\ProductStoreDTO;
use App\Models\Product;
use App\Repositories\interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private Product $model
    ){}

    public function update($id, ProductStoreDTO $dto)
    {
        $product = $this->model->find($id);
        if (!$product) return null;
        $product->update([
            'group_id' => $dto->group_id,
            'tenant_id' => $dto->tenant_id,
            'sku' => $dto->sku,
            'name' => $dto->name,
            'description' => $dto->description,
            'unit' => $dto->unit,
            'color' => $dto->color,
            'material' => $dto->material,
            'min_stock' => $dto->min_stock,
            'is_active' => $dto->is_active,
            'updated_by' => $dto->updated_by,
        ]);
        return $product;
    }

    public function all(ProductSearchDTO $dto)
    {
        $query = $this->model->newQuery();
        return $this->filter($dto, $query)->get();
    }

    private function filter(ProductSearchDTO $dto, $query)
    {
        if ($dto->tenant_id) {
            $query->where('tenant_id', $dto->tenant_id);
        }
        if ($dto->group_id) {
            $query->where('group_id', $dto->group_id);
        }
        if ($dto->sku) {
            $query->where('sku', $dto->sku);
        }
        if ($dto->name) {
            $query->where('name', 'ilike', "%{$dto->name}%");
        }
        if ($dto->description) {
            $query->where('description', 'ilike', "%{$dto->description}%");
        }
        if ($dto->unit) {
            $query->where('unit', $dto->unit);
        }
        if ($dto->color) {
            $query->where('color', $dto->color);
        }
        if ($dto->material) {
            $query->where('material', $dto->material);
        }
        if ($dto->min_stock !== null) {
            $query->where('min_stock', $dto->min_stock);
        }
        if ($dto->is_active !== null) {
            $query->where('is_active', $dto->is_active);
        }
        return $query;
    }

    public function store(ProductStoreDTO $productStoreDTO)
    {
        $product = $this->model->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'group_id' => $productStoreDTO->group_id,
            'tenant_id' => $productStoreDTO->tenant_id,
            'sku' => $productStoreDTO->sku,
            'name' => $productStoreDTO->name,
            'description' => $productStoreDTO->description,
            'unit' => $productStoreDTO->unit,
            'color' => $productStoreDTO->color,
            'material' => $productStoreDTO->material,
            'min_stock' => $productStoreDTO->min_stock,
            'is_active' => $productStoreDTO->is_active,
            'created_by' => $productStoreDTO->created_by,
            'updated_by' => $productStoreDTO->updated_by,
        ]);
        return $product;
    }

    public function findById($id)
    {
        return $this->model->with('group')->find($id);
    }

    public function destroy($id): bool
    {
        $product = $this->model->find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}

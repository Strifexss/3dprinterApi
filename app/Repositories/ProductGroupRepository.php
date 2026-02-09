<?php

namespace App\Repositories;

use App\Dto\ProductGroups\ProductGroupSearchDTO;
use App\Dto\ProductGroups\ProductGroupStoreDTO;
use App\Models\ProductGroup;
use App\Repositories\interfaces\ProductGroupRepositoryInterface;

class ProductGroupRepository implements ProductGroupRepositoryInterface
{
    public function __construct(
        private ProductGroup $model
    ){}
  
    public function all(ProductGroupSearchDTO $dto)
    {
        $query = $this->model->newQuery();
        return $this->filter($dto, $query)->get();
    }

    private function filter(ProductGroupSearchDTO $dto, $query)
    {
        if ($dto->tenant_id) {
            $query->where('tenant_id', $dto->tenant_id);
        }
        if ($dto->name) {
            $query->where('name', 'ilike', "%{$dto->name}%");
        }
        return $query;
    }

    public function store(ProductGroupStoreDTO $groupStoreDTO)
    {
        $group = $this->model->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'tenant_id' => $groupStoreDTO->tenant_id,
            'name' => $groupStoreDTO->name,
            'description' => $groupStoreDTO->description,
            'is_active' => $groupStoreDTO->is_active,
            'created_by' => $groupStoreDTO->created_by,
            'updated_by' => $groupStoreDTO->updated_by,
        ]);
        return $group;
    }

    public function update($id, ProductGroupStoreDTO $dto)
    {
        $group = $this->model->find($id);
        if (!$group) return null;
        $group->update([
            'tenant_id' => $dto->tenant_id,
            'name' => $dto->name,
            'description' => $dto->description,
            'is_active' => $dto->is_active,
            'updated_by' => $dto->updated_by,
        ]);
        return $group;
    }


    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id): bool
    {
        $group = $this->model->find($id);
        if ($group) {
            $group->delete();
            return true;
        }
        return false;
    }
}

<?php

namespace App\Services;

use App\Dto\ProductGroups\ProductGroupSearchDTO;
use App\Dto\ProductGroups\ProductGroupStoreDTO;
use App\Services\interfaces\ProductGroupServiceInterface;
use App\Repositories\interfaces\ProductGroupRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductGroupService implements ProductGroupServiceInterface
{
    protected $productGroupRepository;

    public function __construct(ProductGroupRepositoryInterface $productGroupRepository)
    {
        $this->productGroupRepository = $productGroupRepository;
    }

    public function all(ProductGroupSearchDTO $searchDTO)
    {
        return $this->productGroupRepository->all($searchDTO);
    }

    public function store(ProductGroupStoreDTO $groupStoreDTO)
    {
        return DB::transaction(function () use ($groupStoreDTO) {
            return $this->productGroupRepository->store($groupStoreDTO);
        });
    }

      public function update($id, ProductGroupStoreDTO $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->productGroupRepository->update($id, $dto);
        });
    }

    public function destroy($id): bool
    {
        return $this->productGroupRepository->destroy($id);
    }

    public function findById($id)
    {
        return $this->productGroupRepository->findById($id);
    }
}

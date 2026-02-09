<?php

namespace App\Services;

use App\Dto\Products\ProductSearchDTO;
use App\Dto\Products\ProductStoreDTO;
use App\Services\interfaces\ProductServiceInterface;
use App\Repositories\interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

      public function update($id, ProductStoreDTO $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->productRepository->update($id, $dto);
        });
    }

    public function all(ProductSearchDTO $searchDTO)
    {
        return $this->productRepository->all($searchDTO);
    }

    public function store(ProductStoreDTO $productStoreDTO)
    {
        return DB::transaction(function () use ($productStoreDTO) {
            return $this->productRepository->store($productStoreDTO);
        });
    }

    public function destroy($id): bool
    {
        return $this->productRepository->destroy($id);
    }

    public function findById($id)
    {
        return $this->productRepository->findById($id);
    }
}

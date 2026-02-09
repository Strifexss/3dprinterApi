<?php

namespace App\Repositories\interfaces;

use App\Dto\Products\ProductSearchDTO;
use App\Dto\Products\ProductStoreDTO;

interface ProductRepositoryInterface
{
    public function all(ProductSearchDTO $dto);
    public function store(ProductStoreDTO $productStoreDTO);
    public function findById($id);
    public function update($id, ProductStoreDTO $dto);
    public function destroy($id): bool;
}

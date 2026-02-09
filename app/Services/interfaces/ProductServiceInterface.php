<?php

namespace App\Services\interfaces;

use App\Dto\Products\ProductSearchDTO;
use App\Dto\Products\ProductStoreDTO;

interface ProductServiceInterface
{
    public function all(ProductSearchDTO $searchDTO);
    public function store(ProductStoreDTO $productStoreDTO);
    public function update($id, ProductStoreDTO $dto);
    public function destroy($id): bool;
    public function findById($id);
}

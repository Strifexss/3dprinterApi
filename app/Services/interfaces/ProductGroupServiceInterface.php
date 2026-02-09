<?php

namespace App\Services\interfaces;

use App\Dto\ProductGroups\ProductGroupSearchDTO;
use App\Dto\ProductGroups\ProductGroupStoreDTO;

interface ProductGroupServiceInterface
{
    public function all(ProductGroupSearchDTO $searchDTO);
    public function store(ProductGroupStoreDTO $groupStoreDTO);
    public function update($id, ProductGroupStoreDTO $dto);
    public function destroy($id): bool;
    public function findById($id);
}

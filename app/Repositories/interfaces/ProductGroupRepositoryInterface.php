<?php

namespace App\Repositories\interfaces;

use App\Dto\ProductGroups\ProductGroupSearchDTO;
use App\Dto\ProductGroups\ProductGroupStoreDTO;

interface ProductGroupRepositoryInterface
{
    public function all(ProductGroupSearchDTO $dto);
    public function store(ProductGroupStoreDTO $groupStoreDTO);
    public function findById($id);
    public function update($id, ProductGroupStoreDTO $dto);
    public function destroy($id): bool;
}

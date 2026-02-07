<?php

namespace App\Services\interfaces;

use App\Dto\Printers\PrinterSearchDTO;

interface PrinterServiceInterface
{
    public function all(PrinterSearchDTO $searchDTO);
    public function store(\App\Dto\Printers\PrinterStoreDTO $printerStoreDTO);
    public function destroy(int $id): bool;
    public function findById(int $id);
}

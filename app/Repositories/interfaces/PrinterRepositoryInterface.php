<?php

namespace App\Repositories\interfaces;

use App\Dto\Printers\PrinterSearchDTO;
use App\Dto\Printers\PrinterStoreDTO;

interface PrinterRepositoryInterface
{
    public function all(PrinterSearchDTO $printerSearchDTO);
    public function store(PrinterStoreDTO $printerStoreDTO);
    public function destroy(int $id): bool;
    public function findById(int $id);
}

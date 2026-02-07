<?php

namespace App\Services;

use App\Dto\Printers\PrinterSearchDTO;
use App\Dto\Printers\PrinterStoreDTO;
use App\Services\interfaces\PrinterServiceInterface;
use App\Repositories\interfaces\PrinterRepositoryInterface;

class PrinterService implements PrinterServiceInterface
{
    protected $printerRepository;

    public function __construct(PrinterRepositoryInterface $printerRepository)
    {
        $this->printerRepository = $printerRepository;
    }

    public function all(PrinterSearchDTO $searchDTO)
    {   
        return $this->printerRepository->all($searchDTO);
    }

    public function store(PrinterStoreDTO $printerStoreDTO)
    {
        return $this->printerRepository->store($printerStoreDTO);
    }

    public function destroy(int $id): bool
    {
        return $this->printerRepository->destroy($id);
    }

    public function findById(int $id)
    {
        return $this->printerRepository->findById($id);
    }
}

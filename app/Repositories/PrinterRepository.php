<?php

namespace App\Repositories;

use App\Dto\Printers\PrinterSearchDTO;
use App\Dto\Printers\PrinterStoreDTO;
use App\Models\Printer;
use App\Repositories\interfaces\PrinterRepositoryInterface;
use Illuminate\Support\Facades\DB;

class PrinterRepository implements PrinterRepositoryInterface
{
    public function __construct(
        private Printer $model
    ){}

    public function all(PrinterSearchDTO $dto)
    {
        try {
            $query = $this->model->newQuery();
            $query = $this->filter($dto, $query);

            return $query->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function filter(PrinterSearchDTO $dto, $query)
    {
        if ($dto->user_id) {
            $query->where('user_id', $dto->user_id);
        }
        return $query;
    }

    public function store(PrinterStoreDTO $printerStoreDTO)
    {
        return $this->model->create([
            'user_id' => $printerStoreDTO->user_id,
            'name' => $printerStoreDTO->name,
            'model' => $printerStoreDTO->model,
            'manufacturer' => $printerStoreDTO->manufacturer,
            'serial_number' => $printerStoreDTO->serial_number,
            'technology' => $printerStoreDTO->technology,
            'acquisition_date' => $printerStoreDTO->acquisition_date,
            'warranty_until' => $printerStoreDTO->warranty_until,
            'status' => $printerStoreDTO->status,
            'location' => $printerStoreDTO->location,
            'notes' => $printerStoreDTO->notes,
        ]);
    }

    public function destroy(int $id): bool
    {
        $printer = $this->model->find($id);
        if ($printer) {
            return $printer->delete();
        }
        return false;
    }

    public function findById(int $id)
    {
        try {
            return $this->model->find($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

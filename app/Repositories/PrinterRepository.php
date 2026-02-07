<?php

namespace App\Repositories;

use App\Dto\Printers\PrinterSearchDTO;
use App\Models\Printer;
use App\Repositories\interfaces\PrinterRepositoryInterface;

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

    public function store(\App\Dto\Printers\PrinterStoreDTO $printerStoreDTO)
    {
        try {
            return $this->model->create([
                'user_id' => $printerStoreDTO->user_id,
                'name' => $printerStoreDTO->name,
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        try {
            $printer = $this->model->find($id);
            if ($printer) {
                return $printer->delete();
            }
            return false;
        } catch (\Exception $e) {
            throw $e;
        }
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

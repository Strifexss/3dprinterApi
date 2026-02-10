<?php

namespace App\Dto\Printers;

use App\Dto\DTO;

class PrinterStoreDTO extends DTO
{
    public string $user_id;
    public string $name;
    public string $model = null;
    public string $manufacturer = null;
    public string $serial_number = null;
    public string $technology = null;
    public string $acquisition_date = null;
    public string $warranty_until = null;
    public string $status = null;
    public string $location = null;
    public string $notes = null;
}

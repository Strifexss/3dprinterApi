<?php

namespace App\Dto\Printers;

use App\Dto\DTO;

class PrinterSearchDTO extends DTO
{
    public ?string $user_id = null;
    public ?string $name = null;
}

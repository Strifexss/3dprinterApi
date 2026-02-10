<?php

namespace App\Dto\KanbanBoards;

use App\Dto\DTO;

class KanbanBoardSearchDto extends DTO
{
    public string $tenant_id;
    public string $printer_id = null;
    public ?string $from_status = null;
    public ?string $to_status = null;
    public string $changed_by_id = null;
    public ?string $changed_at = null;
}

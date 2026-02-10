<?php

namespace App\Dto\KanbanBoards;

use App\Dto\DTO;

class KanbanBoardDto extends DTO
{
    public $id = null;
    public $tenant_id;
    public $printer_id = null;
    public $from_status = null;
    public $to_status = null;
    public $changed_by_id = null;
    public $changed_at = null;
    public $notes = null;
}

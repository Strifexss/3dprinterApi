<?php

namespace App\Services\interfaces;

use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;

interface KanbanBoardServiceInterface
{
    public function all(KanbanBoardSearchDto $dto = null);
    public function find($id);
    public function create(KanbanBoardDto $dto);
    public function update($id, KanbanBoardDto $dto);
    public function delete($id);
}

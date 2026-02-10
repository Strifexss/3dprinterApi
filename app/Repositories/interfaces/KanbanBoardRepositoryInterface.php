<?php

namespace App\Repositories\interfaces;

use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;

interface KanbanBoardRepositoryInterface
{
    public function all(KanbanBoardSearchDto $dto);
    public function find($id);
    public function create(KanbanBoardDto $dto);
    public function update($id, KanbanBoardDto $dto);
    public function delete($id);
}

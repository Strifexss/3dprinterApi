<?php

namespace App\Repositories;

use App\Models\KanbanBoard;
use App\Repositories\interfaces\KanbanBoardRepositoryInterface;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;
use App\Dto\KanbanBoards\KanbanBoardDto;

class KanbanBoardRepository implements KanbanBoardRepositoryInterface
{
    public function all(KanbanBoardSearchDto $dto)
    {
        $query = $this->filter($dto, KanbanBoard::query());
        return $query->get();
    }

    private function filter(KanbanBoardSearchDto $dto, $query)
    {
        if ($dto->tenant_id) {
            $query->where('tenant_id', $dto->tenant_id);
        }
        if ($dto->printer_id) {
            $query->where('printer_id', $dto->printer_id);
        }
        if ($dto->from_status) {
            $query->where('from_status', $dto->from_status);
        }
        if ($dto->to_status) {
            $query->where('to_status', $dto->to_status);
        }
        if ($dto->changed_by_id) {
            $query->where('changed_by_id', $dto->changed_by_id);
        }
        if ($dto->changed_at) {
            $query->whereDate('changed_at', $dto->changed_at);
        }
        return $query;
    }

    public function find($id)
    {
        return KanbanBoard::findOrFail($id);
    }

    public function create(KanbanBoardDto $dto)
    {
        return KanbanBoard::create($dto->toArray());
    }

    public function update($id, KanbanBoardDto $dto)
    {
        $kanban = KanbanBoard::findOrFail($id);
        $kanban->update($dto->toArray());
        return $kanban;
    }

    public function delete($id)
    {
        $kanban = KanbanBoard::findOrFail($id);
        return $kanban->delete();
    }
}

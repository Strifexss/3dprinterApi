use Illuminate\Support\Facades\DB;
<?php

namespace App\Services;

use App\Repositories\interfaces\KanbanBoardRepositoryInterface;
use App\Services\interfaces\KanbanBoardServiceInterface;
use App\Dto\KanbanBoards\KanbanBoardDto;
use Illuminate\Support\Facades\DB;

class KanbanBoardService implements KanbanBoardServiceInterface
{
    protected $repository;

    public function __construct(KanbanBoardRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all($searchDto = null)
    {
        return $this->repository->all($searchDto);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }


    public function create(KanbanBoardDto $dto)
    {
        return DB::transaction(function () use ($dto) {
            return $this->repository->create($dto);
        });
    }

    public function update($id, KanbanBoardDto $dto)
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto);
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }
}

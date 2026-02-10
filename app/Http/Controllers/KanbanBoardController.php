<?php

namespace App\Http\Controllers;

use App\Services\interfaces\KanbanBoardServiceInterface;
use App\Http\Requests\KanbanBoards\StoreKanbanBoardRequest;
use App\Http\Requests\KanbanBoards\UpdateKanbanBoardRequest;
use App\Http\Requests\KanbanBoards\KanbanBoardSearchRequest;
use App\Dto\KanbanBoards\KanbanBoardDto;
use App\Dto\KanbanBoards\KanbanBoardSearchDto;
use App\Http\Resources\KanbanBoardResource;

class KanbanBoardController extends Controller
{
    protected $service;

    public function __construct(KanbanBoardServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(KanbanBoardSearchRequest $request)
    {
        $searchDto = new KanbanBoardSearchDto($request->validated());
        $kanbans = $this->service->all($searchDto);
        return response()->json(KanbanBoardResource::collection($kanbans), 200);
    }

    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    public function store(StoreKanbanBoardRequest $request)
    {
        $dto = new KanbanBoardDto($request->validated());
        $created = $this->service->create($dto);
        return response()->json($created, 201);
    }

    public function update(UpdateKanbanBoardRequest $request, $id)
    {
        $dto = new KanbanBoardDto($request->validated());
        $updated = $this->service->update($id, $dto);
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}

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
        try {
            $kanbans = $this->service->all(new KanbanBoardSearchDto($request->validated()));
            return response()->json(KanbanBoardResource::collection($kanbans), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar kanban boards.'], 500);
        }
    }

    public function show($id)
    {
        try {
            if ($kanban = $this->service->find($id)) {
                return response()->json(new KanbanBoardResource($kanban), 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar kanban board.'], 500);
        }
    }

    public function store(StoreKanbanBoardRequest $request)
    {
        try {
            $created = $this->service->create(new KanbanBoardDto($request->validated()));
            return response()->json(new KanbanBoardResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar kanban board.'], 500);
        }
    }

    public function update(UpdateKanbanBoardRequest $request, $id)
    {
        try {
            if ($updated = $this->service->update($id, new KanbanBoardDto($request->validated()))) {
                return response()->json(new KanbanBoardResource($updated), 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar kanban board.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->service->delete($id)) {
                return response()->json(['message' => 'Kanban board removido com sucesso.'], 200);
            }
            return response()->json(['error' => 'Kanban board não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover kanban board.'], 500);
        }
    }
}

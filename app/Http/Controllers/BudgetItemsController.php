<?php

namespace App\Http\Controllers;

use App\Dto\Budgets\BudgetItemDto;
use App\Dto\Budgets\BudgetItemSearchDto;
use App\Http\Requests\BudgetItems\BudgetItemSearchRequest;
use App\Http\Requests\BudgetItems\StoreBudgetItemRequest;
use App\Http\Requests\BudgetItems\UpdateBudgetItemRequest;
use App\Http\Resources\BudgetItemResource;
use App\Services\interfaces\BudgetItemServiceInterface;
use Illuminate\Http\JsonResponse;

class BudgetItemsController extends Controller
{
    public function __construct(private BudgetItemServiceInterface $service) {}

    public function index(BudgetItemSearchRequest $request): JsonResponse
    {
        try {
            $items = $this->service->all(new BudgetItemSearchDto($request->validated()));
            return response()->json(BudgetItemResource::collection($items), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching budget items.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $item = $this->service->find($id);
            if ($item) {
                return response()->json(new BudgetItemResource($item), 200);
            }
            return response()->json(['error' => 'Budget item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching budget item.'], 500);
        }
    }

    public function store(StoreBudgetItemRequest $request): JsonResponse
    {
        try {
            $created = $this->service->create(new BudgetItemDto($request->validated()));
            return response()->json(new BudgetItemResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving budget item.'], 500);
        }
    }

    public function update(UpdateBudgetItemRequest $request, $id): JsonResponse
    {
        try {
            $updated = $this->service->update($id, new BudgetItemDto($request->validated()));
            if ($updated) {
                return response()->json(new BudgetItemResource($updated), 200);
            }
            return response()->json(['error' => 'Budget item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating budget item.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->service->delete($id);
            if ($deleted) {
                return response()->json(['message' => 'Budget item deleted successfully.'], 200);
            }
            return response()->json(['error' => 'Budget item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting budget item.'], 500);
        }
    }
}

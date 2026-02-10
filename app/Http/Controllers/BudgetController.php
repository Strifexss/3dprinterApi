<?php
namespace App\Http\Controllers;

use App\Http\Requests\Budgets\StoreBudgetRequest;
use App\Http\Requests\Budgets\UpdateBudgetRequest;
use App\Http\Requests\Budgets\BudgetSearchRequest;
use App\Dto\Budgets\BudgetDto;
use App\Dto\Budgets\BudgetSearchDto;
use App\Http\Resources\BudgetResource;
use App\Services\interfaces\BudgetServiceInterface;
use Illuminate\Http\JsonResponse;

class BudgetController extends Controller
{
    public function __construct(private BudgetServiceInterface $service) {}

    public function index(BudgetSearchRequest $request): JsonResponse
    {
        try {
            $budgets = $this->service->all(new BudgetSearchDto($request->validated()));
            return response()->json(BudgetResource::collection($budgets), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching budgets.'], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $budget = $this->service->find($id);
            if ($budget) {
                return response()->json(new BudgetResource($budget), 200);
            }
            return response()->json(['error' => 'Budget not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching budget.'], 500);
        }
    }

    public function store(StoreBudgetRequest $request): JsonResponse
    {
        try {
            $created = $this->service->create(new BudgetDto($request->validated()));
            return response()->json(new BudgetResource($created), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving budget.'], 500);
        }
    }

    public function update(UpdateBudgetRequest $request, $id): JsonResponse
    {
        try {
            $updated = $this->service->update($id, new BudgetDto($request->validated()));
            if ($updated) {
                return response()->json(new BudgetResource($updated), 200);
            }
            return response()->json(['error' => 'Budget not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating budget.'], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->service->delete($id);
            if ($deleted) {
                return response()->json(['message' => 'Budget deleted successfully.'], 200);
            }
            return response()->json(['error' => 'Budget not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting budget.'], 500);
        }
    }
}

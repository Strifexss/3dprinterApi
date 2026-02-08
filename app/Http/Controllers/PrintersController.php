<?php

namespace App\Http\Controllers;

use App\Dto\Printers\PrinterSearchDTO;
use App\Dto\Printers\PrinterStoreDTO;
use App\Http\Requests\StorePrinterRequest;
use Illuminate\Http\Request;
use App\Services\interfaces\PrinterServiceInterface;
use App\Http\Resources\PrinterResource;

class PrintersController extends Controller
{

    public function __construct(
        private PrinterServiceInterface $printerService
    ) {}

    public function index(Request $request)
    {
        try {
            $dto = new PrinterSearchDTO($request->all());
            $printers = $this->printerService->all($dto);
        
            return response()->json(PrinterResource::collection($printers), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $printer = $this->printerService->findById($id);
            if ($printer) {
                return response()->json(new PrinterResource($printer), 200);
            }
            return response()->json(['error' => 'Printer not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StorePrinterRequest $request)
    {
        try {
            $dto = new PrinterStoreDTO($request->validated());
            $printer = $this->printerService->store($dto);
            return response()->json(new PrinterResource($printer), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->printerService->destroy($id);
            if ($deleted) {
                return response()->json(null, 204);
            }
            return response()->json(['error' => 'Printer not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
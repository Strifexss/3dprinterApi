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
            $printers = $this->printerService->all(new PrinterSearchDTO($request->all()));
            return response()->json(PrinterResource::collection($printers), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $printer = $this->printerService->findById($id);
            if ($printer) {
                return response()->json(new PrinterResource($printer), 200);
            }
            return response()->json(['message' => 'Impressora não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function store(StorePrinterRequest $request)
    {
        try {
            $printer = $this->printerService->store(new PrinterStoreDTO($request->validated()));
            return response()->json(new PrinterResource($printer), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($this->printerService->destroy($id)) {
                return response()->json(null, 204);
            }
            return response()->json(['message' => 'Impressora não encontrada'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro interno no servidor'], 500);
        }
    }
}
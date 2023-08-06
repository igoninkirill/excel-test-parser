<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\ImportExcelStoreRequest;
use App\Services\Import\ImportExcelService;

class ImportExcelController extends Controller
{
    public function __construct(public ImportExcelService $service)
    {}

    public function import(ImportExcelStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->import($request->validated()));
    }
}

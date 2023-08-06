<?php

namespace App\Http\Controllers\Row;

use App\Http\Controllers\Controller;
use App\Services\Row\RowService;

class RowController extends Controller
{
    public function __construct(public RowService $service)
    {}

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->getIndexData());
    }
}

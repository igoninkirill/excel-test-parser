<?php

namespace App\Services\Row;

use App\Http\Resources\Row\RowResource;
use App\Models\Rows\Row;
use Illuminate\Support\Collection;

class RowService
{
    /**
     * @return Collection
     */
    public function getIndexData(): Collection
    {
        return RowResource::collection(Row::all())->groupBy('date');
    }
}

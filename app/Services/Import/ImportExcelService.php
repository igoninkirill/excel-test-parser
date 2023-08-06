<?php

namespace App\Services\Import;

class ImportExcelService
{
    public function import(array $data): bool
    {
        $this->parseExcel();
        return true;
    }

    protected function parseExcel(): void
    {}
}

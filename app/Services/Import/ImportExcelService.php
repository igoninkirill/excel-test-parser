<?php

namespace App\Services\Import;

use App\Jobs\Parsing\ParseExcelJob;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ImportExcelService
{
    public function import(array $data): \Illuminate\Http\JsonResponse
    {
        $path = $data['file']->store('excel_files');
        ParseExcelJob::dispatch($path);
        return response()->json(['message' => 'File uploaded and parsing started.'], 200);
    }

    public function parse(string $filePath): \Generator
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(storage_path('app/' . $filePath));
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow('A');
        for ($row = 2; $row <= $highestRow; $row += 1000) {
            $chunk = [];
            for ($chunkRow = $row; $chunkRow < $row + 1000 && $chunkRow <= $highestRow; $chunkRow++) {
                $name = $worksheet->getCell('B' . $chunkRow)->getValue();
                $date = $worksheet->getCell('C' . $chunkRow)->getValue();
                if ($name && $date) {
                    $chunk[] = [
                        'name' => $name,
                        'date' => ExcelDate::excelToDateTimeObject($date),
                    ];
                }
            }
            yield $chunk;
        }
    }
}

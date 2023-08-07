<?php

namespace App\Jobs\Parsing;

use App\Models\Rows\Row;
use App\Services\Import\ImportExcelService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ParseExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $path;

    /**
     * Create a new job instance.
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            foreach (app(ImportExcelService::class)->parse($this->path) as $chunk) {
                foreach ($chunk as $data) {
                    Row::create($data);
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getLine());
        }
    }
}

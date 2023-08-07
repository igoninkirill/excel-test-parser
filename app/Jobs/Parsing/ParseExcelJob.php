<?php

namespace App\Jobs\Parsing;

use App\Events\RowCreatedEvent;
use App\Models\Rows\Row;
use App\Services\Import\ImportExcelService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

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
            $i = 1;
            foreach (app(ImportExcelService::class)->parse($this->path) as $chunk) {
                foreach ($chunk as $data) {
                    Row::create($data);
                    Redis::set(Str::uuid()->toString(), $i++);
                    event(new RowCreatedEvent());
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getLine());
        }
    }
}

<?php

namespace App\Jobs;

use App\Events\ImportDone;
use App\Imports\TransactionsImport;
use App\Repositories\Contracts\CSVsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProcessExcelImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user ID of the imported file.
     *
     * @var string
     */
    protected $userId;

    /**
     * The imported file path.
     *
     * @var string
     */
    protected $file;

    /**
     * The imported file rows count.
     *
     * @var int
     */
    protected $rows;

    /**
     * The CSVs repository.
     *
     * @var \App\Repositories\Contracts\CSVsRepository
     */
    protected $csvsRepository;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param string $file
     * @return void
     */
    public function __construct(int $userId, string $file, int $rows)
    {
        $this->file = $file;
        $this->userId = $userId;
        $this->rows = $rows;
        $this->csvsRepository = app(CSVsRepository::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csv = $this->csvsRepository->store([
            'user_id' => $this->userId,
            'file' => $this->file,
            'rows_count' => $this->rows
        ]);
        //
        DB::beginTransaction();
        //
        Excel::import(new TransactionsImport($this->userId), $this->file);
        //
        DB::commit();
        //
        $this->csvsRepository->update($csv->id, [
            'completed_at' => now()
        ]);
        //
        broadcast(new ImportDone($this->userId));
    }
}

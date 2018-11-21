<?php

namespace App\Jobs;

use App\Service\TransferDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTransferDataGeneration /** implements ShouldQueue **/
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customerTransfersPerMonthCount;

    /**
     * Create a new job instance.
     *
     * @param int $customerTransfersPerMonthCount
     */
    public function __construct(int $customerTransfersPerMonthCount)
    {
        $this->customerTransfersPerMonthCount = $customerTransfersPerMonthCount;
    }

    /**
     * Execute the job.
     *
     * @param TransferDataService $transferDataService
     * @return void
     */
    public function handle(TransferDataService $transferDataService)
    {
        $transferDataService->generate($this->customerTransfersPerMonthCount);
    }
}

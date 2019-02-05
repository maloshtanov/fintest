<?php

namespace App\Jobs;

use App\Models\Transfer;

use App\Services\TransferService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessDeferredTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Transfer
     */
    protected $transfer;

    /**
     * Create a new job instance.
     *
     * @param  Transfer  $transfer
     * @return void
     */
    public function __construct(Transfer $transfer)
    {
        $this->transfer = $transfer;
    }

    /**
     * Execute the job.
     *
     * @param TransferService $service
     * @return void
     */
    public function handle(TransferService $service)
    {
        try {
            $service->receive($this->transfer);
        } catch (Exception $e) {
            $service->refund($this->transfer);
        }
    }
}

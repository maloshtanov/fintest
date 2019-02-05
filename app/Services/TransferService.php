<?php

namespace App\Services;

use App\Http\Requests\EnrollRequest;
use App\Jobs\ProcessDeferredTransfer;
use App\Models\Transfer;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransferService
{
    /**
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param EnrollRequest $request
     * @return true|null
     */
    public function enroll($user, EnrollRequest $request)
    {
        return DB::transaction(function () use ($user, $request) {

            //Проверяем наличие необходимых средств и блокируем чтение строки другими запросами до окончания транзакции
            $canEnroll = (bool) $user->where('id', $user->id)
                ->where('balance', '>=', $request->amount)
                ->lockForUpdate()
                ->first();

            if ($canEnroll) {
                $user->where('id', $user->id)
                    ->decrement('balance', $request->amount);

                $transfer = $user->transfers()
                    ->create([
                        'receiver_id' => $request->receiver_id,
                        'amount' => $request->amount
                    ]);

                ProcessDeferredTransfer::dispatch($transfer)
                    ->delay(
                        Carbon::parse($request->date_time)->setTimezone(now()->timezone)
                    );

                return true;
            }
        });
    }

    /**
     * @param Transfer $transfer
     * @return void
     */
    public function receive(Transfer $transfer)
    {
        DB::transaction(function () use ($transfer) {

            $transfer->receiver()
                ->increment('balance', $transfer->amount);

            $transfer->is_processed = true;
            $transfer->save();
        });
    }

    /**
     * @param Transfer $transfer
     * @return void
     */
    public function refund(Transfer $transfer)
    {
        DB::transaction(function () use ($transfer) {

            $transfer->sender()
                ->increment('balance', $transfer->amount);

            $transfer->delete();
        });
    }
}

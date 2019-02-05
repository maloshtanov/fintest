<?php

namespace App\Services;

use App\Models\Transfer;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;

class UserService
{
    /**
     * @param User|\Illuminate\Contracts\Auth\Authenticatable|null $authUser
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getUnAuthUsers($authUser)
    {
        return User::when($authUser, function (Builder $query, $user) {
            $query->where('id', '!=', $user->id);
        })->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getUsersWithLastTransfers()
    {
        return User::select([
                'users.name',
                't1.amount as transfer_amount',
                't1.updated_at as transfer_date',
                't1.is_processed as transfer_status',
            ])
            ->join('transfers as t1', 'users.id', '=', 't1.sender_id')
            ->leftJoin('transfers as t2', function (JoinClause $join) {
                $join->on('t2.sender_id', '=', 't1.sender_id')
                    ->on('t2.updated_at', '>', 't1.updated_at');
            })
            ->whereNull('t2.sender_id')
            ->orderByDesc('t1.updated_at')
            ->get();
    }

    /**
     * @param User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getAccountFlow($user)
    {
        $fields = 'transfers.*, if(u1.id = 2, u2.name, u1.name) as name, sender_id = ' . $user->id . ' as is_transfer';

        return Transfer::selectRaw($fields)
            ->leftJoin('users as u1', 'u1.id', '=', 'receiver_id')
            ->leftJoin('users as u2', 'u2.id', '=', 'sender_id')
            ->where(function (Builder $query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->where('is_processed', true)
            ->latest('updated_at')
            ->get();

//        return $user->transfers()
//            ->selectRaw($fields)
//            ->leftJoin('users', 'users.id', '=', 'receiver_id')
//            ->where('is_processed', true)
//            ->union(
//                $user->receipts()
//                    ->selectRaw($fields)
//                    ->leftJoin('users', 'users.id', '=', 'sender_id')
//                    ->where('is_processed', true)
//            )
//            ->latest('updated_at')
//            ->get();
    }
}

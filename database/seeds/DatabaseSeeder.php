<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $maxSeedUsers = 30;
    private $maxSeedTransfers = 10;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function () {
            $users = factory(App\User::class, $this->maxSeedUsers)->create();

            $users->each(function ($user) use ($users) {
                $maxSeedTransfers = $this->maxSeedTransfers;

                while ($maxSeedTransfers-- > 0) {
                    $receiver = $users->whereNotIn('id', $user->id)->random();

                    $user->transfers()->save(
                        factory(App\Models\Transfer::class)->make([
                            'receiver_id' => $receiver->id,
                        ])
                    );
                }
            });
        });
    }
}

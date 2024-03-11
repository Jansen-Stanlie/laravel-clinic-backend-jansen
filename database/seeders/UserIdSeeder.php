<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $index => $user) {
            $userId = 'USR' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $user->user_id = $userId;
            $user->save();
        }
    }
}

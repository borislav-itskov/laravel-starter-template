<?php

use App\Services\UserService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userService = app(UserService::class);
        $users = [];
        for ($i=0; $i < 10; $i++) { 
            $users[] = [
                'name' => Str::random(10),
                'email' => Str::random(10),
                'password' => bcrypt(Str::random(10)),
            ];
        }
        $userService->bulkInsert($users);
    }
}

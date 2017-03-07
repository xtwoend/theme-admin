<?php

use App\Entities\User;
use Illuminate\Database\Seeder;

class MemberUserSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'email'     => 'user@user.com',
        //     'name'      => 'user',
        //     'password'  => bcrypt('user123')
        // ]);

        $users = factory(User::class, 1000)->create();
    }
}

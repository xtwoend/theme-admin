<?php

use App\Entities\Admin;
use Illuminate\Database\Seeder;

class AdminUserSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email'     => 'admin@admin.com',
            'name'      => 'administrator',
            'password'  => bcrypt('admin123')
        ]);
    }
}

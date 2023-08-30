<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // admin user
        $user = new App\Models\User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = \Illuminate\Support\Facades\Hash::make('1');
        $user->save();

    }
}

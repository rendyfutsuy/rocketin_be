<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Modules\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = new User();
        $seeder->unguard();
        $seeder->unsetEventDispatcher();
        
        $items = [
            [
                'name' => 'Admin Konsep',
                'email' => 'kolombarisxadmin@konsep.com',
                'username' => 'admin',
                'password' => Hash::make('k0nsep1@biblEmarK'),
                'level' => User::ADMIN, // user yang sudah diregister dan sudah aktif
                'email_verified_at' => Carbon::now()
            ],
        ];

        foreach ($items as $item) {
            if (! User::where('email', $item['email'])->exists()) {
                $seeder->create($item);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@id.go',
            'no_hp' => '081232543533',
            'avatar' => 'assets/media/avatars/300-1.jpg',
            'password' => bcrypt('L0w0ngan@Berkah'),
        ]);

        $admin->assignRole('Admin');

        $perusahaan = User::create([
            'name' => 'Bank Jatim',
            'email' => 'jatim@id.go',
            'no_hp' => '082335596666',
            'avatar' => 'assets/media/avatars/logo_bank_jatim.png',
            'password' => bcrypt('Mur4l@Berkah'),
        ]);

        $perusahaan->assignRole('Perusahaan');
    }
}

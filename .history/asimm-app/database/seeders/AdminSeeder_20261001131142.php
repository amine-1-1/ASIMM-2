<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => env('ADMIN_EMAIL', 'admin@asimm.ca')]);

        $admin->name = 'Administrateur';
        $admin->first_name = 'Admin';
        $admin->last_name = 'ASIMM';
        $password = env('ADMIN_PASSWORD', 'ChangeThisPassword123!');
        $admin->role_id = Role::where('name', 'admin')->value('id');


        // Mot de passe défini seulement à la création
        if (! $admin->exists) {
            $admin->password = Hash::make(env('ADMIN_PASSWORD', 'ChangeThisPassword123!'));
        }

        $admin->save();
    }
}

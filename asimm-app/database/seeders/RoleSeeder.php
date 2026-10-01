<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin' => 'Administrateur',
            'membre' => 'Membre',
        ];

        foreach ($roles as $name => $label) {
            Role::updateOrCreate(['name' => $name], ['label' => $label]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar roles en la tabla roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);
    }
}

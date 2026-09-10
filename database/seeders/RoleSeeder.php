<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Define roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $organizer = Role::create(['name' => 'organizer']);
        $scanner = Role::create(['name' => 'scanner']);
        $participant = Role::create(['name' => 'participant']);

        // Create a default super admin user
        $adminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole($superAdmin);

        // Create a default organizer
        $organizerUser = User::create([
            'name' => 'Organizer',
            'email' => 'organizer@event.com',
            'password' => Hash::make('password'),
        ]);
        $organizerUser->assignRole($organizer);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        //define all permission
        $permissions = [
            'show.dashboard',
            'create.room' , 'show.room' , 'delete.room' , 'update.room',
            'create.booking' , 'show.booking' , 'delete.booking' , 'update.booking',
            'create.user' , 'show.user' , 'delete.user' , 'update.user',
            'create.gallery' , 'show.gallery' , 'delete.gallery' , 'update.gallery',
            'create.offer' , 'show.offer' , 'delete.offer' , 'update.offer',
        ];

        //create permission
        foreach ($permissions as $permission) {
            Permission::findOrCreate( $permission , 'web');
        }

        //assign permissions to admin role
        $adminRole->syncPermissions($permissions);

        //assign permissions to user role
        $userRole->givePermissionTo([
            'show.room',
            'create.booking' , 'show.booking' , 'delete.booking' , 'update.booking',
            'show.user' , 'update.user',
            'show.gallery',
            'show.offer',
        ]);

        //create default admin
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'phone' => '0994875925',
            'password' =>bcrypt('11111111'),
            'role' => 0,
            'wallet' => 0,
            'image' => fake()->text(20),
        ]);

        //assign the new admin to the adminRole
        $admin->assignRole($adminRole);
        $admin['token'] = $admin->createToken("token")->plainTextToken;

        //create default user
        $user = User::factory()->create([
            'name' => 'suer',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'phone' => '0994875925',
            'password' =>bcrypt('11111111'),
            'role' => 0,
            'wallet' => 0,
            'image' => fake()->text(20),
        ]);

        //assign the new user to the userRole
        $user->assignRole($userRole);
        $user['token'] = $user->createToken("token")->plainTextToken;
    }
}

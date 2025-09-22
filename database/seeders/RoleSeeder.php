<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use illuminate\support\Facades\Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // Crear roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $profesorRole = Role::firstOrCreate(['name' => 'profesor']);
        $estudianteRole = Role::firstOrCreate(['name' => 'estudiante']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'usDocumento'=> '38123123',
                'usNombre' => 'User',
                'usApellido' => 'Admin',
                'usTelefono'=> "3435612312",
                'usDomicilio'=> "Barrio Palomar",
                'usLocalidad'=> "Nogoyá, Entre Ríos",
                'password' => Hash::make('38123123'), // Cambia 'password' por una contraseña segura
            ]
        );
        $admin->assignRole('admin');

        // Create an example Profesor user
        $profesor = User::firstOrCreate(
            ['email' => 'profesor@example.com'],
            [
                'usDocumento'=> '38123122',
                'usNombre' => 'User',
                'usApellido' => 'Profesor',
                'usTelefono'=> "3435612312",
                'usDomicilio'=> "Barrio Palomar",
                'usLocalidad'=> "Nogoyá, Entre Ríos",
                'password' => Hash::make('38123123'),
            ]
        );
        $profesor->assignRole('profesor');

        // Create an example Estudiante user
        $estudiante = User::firstOrCreate(
            ['email' => 'estudiante@example.com'],
            [
                'usDocumento'=> '38123133',
                'usNombre' => 'User',
                'usApellido' => 'Estudiante',
                'usTelefono'=> "3435612312",
                'usDomicilio'=> "Barrio Palomar",
                'usLocalidad'=> "Nogoyá, Entre Ríos",
                'password' => Hash::make('38123123'),
            ]
        );
        $estudiante->assignRole('estudiante');

        $this->command->info('Roles and initial users created successfully!');
    }
    
}

<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Materia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarreraMateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Crea 10 carreras y, por cada una, 20 unidades curriculares
        Carrera::factory(4)
            ->has(Materia::factory()->count(10))
            ->create();
    }
}

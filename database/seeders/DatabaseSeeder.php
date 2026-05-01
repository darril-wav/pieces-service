<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Block;
use App\Models\Piece;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $project1 = Project::create([
            'name'        => 'Proyecto Alpha',
            'description' => 'Primer proyecto de fabricación',
        ]);

        $project2 = Project::create([
            'name'        => 'Proyecto Beta',
            'description' => 'Segundo proyecto de fabricación',
        ]);

        $block1 = $project1->blocks()->create(['name' => 'Bloque 01']);
        $block2 = $project1->blocks()->create(['name' => 'Bloque 02']);
        $block3 = $project2->blocks()->create(['name' => 'Bloque 01']);

        $block1->pieces()->createMany([
            ['name' => 'Pieza-001', 'peso_teorico' => 12.500, 'estado' => 'pendiente'],
            ['name' => 'Pieza-002', 'peso_teorico' => 8.750,  'estado' => 'pendiente'],
            ['name' => 'Pieza-003', 'peso_teorico' => 15.200, 'estado' => 'fabricada', 'peso_real' => 15.100],
        ]);

        $block2->pieces()->createMany([
            ['name' => 'Pieza-004', 'peso_teorico' => 6.300,  'estado' => 'pendiente'],
            ['name' => 'Pieza-005', 'peso_teorico' => 20.000, 'estado' => 'fabricada', 'peso_real' => 20.500],
        ]);

        $block3->pieces()->createMany([
            ['name' => 'Pieza-001', 'peso_teorico' => 9.100,  'estado' => 'pendiente'],
            ['name' => 'Pieza-002', 'peso_teorico' => 11.400, 'estado' => 'fabricada', 'peso_real' => 11.200],
        ]);
    }
}
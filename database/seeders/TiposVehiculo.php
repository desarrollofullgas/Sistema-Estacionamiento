<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiposVehiculo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'name' => 'Automóvil'
            ],
            [
                'name' => 'Motocicleta'
            ],
            [
                'name' => 'Camioneta'
            ],
        ];
        foreach($tipos as $tipo) {
            Tipo::create($tipo);
        }
    }
}

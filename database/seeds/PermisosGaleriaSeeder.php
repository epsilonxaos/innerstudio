<?php

use App\Permiso;
use Illuminate\Database\Seeder;

class PermisosGaleriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            [
                'permiso' => 'cre_galeria',
                'placeholder' => 'Crear galeria',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'permiso' => 'acc_instructor',
                'placeholder' => 'Modificar galeria',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($permisos as $key => $value) {
            Permiso::insert($value);
        }
    }
}

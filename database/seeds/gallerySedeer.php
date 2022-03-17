<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class gallerySedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('galeria')->insert([
            'name' => 'front',
        ]);
        DB::table('galeria')->insert([
            'name' => "bottom",
        ]);
    }
}

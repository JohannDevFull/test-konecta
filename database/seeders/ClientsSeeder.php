<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('clients')->insert([
            'name'      =>  'Pepito Peréz',
            'email'     =>  'pp@test.com'
        ]);

        DB::table('providers')->insert([
            'name'      =>  'Fulanito de tales',
            'email'     =>  'fdt@test.com'
        ]);

        DB::table('providers')->insert([
            'name'      =>  'Client Test One',
            'email'     =>  'cl01@test.com'
        ]);

        DB::table('providers')->insert([
            'name'      =>  'Client Test Two',
            'email'     =>  'cl02@test.com'
        ]);
    }
}

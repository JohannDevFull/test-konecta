<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $list_categories='[
            {
                "name":"Bebidas",
                "description":"Descipción de ejmeplo contenidos Liquidos"
            },
            {
                "name":"Postres",
                "description":"Descipción de ejmeplo postres de panaderia"
            },
            {
                "name":"Otros",
                "description":"Descipción de ejmeplo"
            }
        ]';

        $cotegories=json_decode($list_categories);

        foreach ($cotegories as $key ) 
        {
            // code...
            DB::table('categories')->insert([
                'name'          =>  $key->name,
                'description'   =>  $key->description
            ]);
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $list_products='[
            {
                "name":"Cafe xpress",
                "ref":"ref-000001",
                "unitary_value":3000.00,
                "stock":50,
                "weight":360,
                "fk_category_id":1
            },
            {
                "name":"Capuchino",
                "ref":"ref-000001",
                "unitary_value":7500.00,
                "stock":50,
                "weight":360,
                "fk_category_id":1
            },
            {
                "name":"Gaseosa",
                "ref":"ref-000001",
                "unitary_value":2500.00,
                "stock":50,
                "weight":360,
                "fk_category_id":1
            },
            {
                "name":"Jugo hit",
                "ref":"ref-000002",
                "unitary_value":2500.00,
                "stock":50,
                "weight":360,
                "fk_category_id":1
            },
            {
                "name":"Brawni",
                "ref":"ref-000003",
                "unitary_value":2500.00,
                "stock":35,
                "weight":360,
                "fk_category_id":3
            },
            {
                "name":"Ponque",
                "ref":"ref-000891",
                "unitary_value":5500.00,
                "stock":20,
                "weight":360,
                "fk_category_id":2
            },
            {
                "name":"Torta XD",
                "ref":"ref-000891",
                "unitary_value":4000.00,
                "stock":20,
                "weight":360,
                "fk_category_id":2
            }

        ]';

        $products=json_decode($list_products);

        foreach ($products as $key ) 
        {
            // code...
            DB::table('products')->insert([
                'name'          =>  $key->name,
                'ref'           =>  $key->ref,
                'unitary_value' =>  $key->unitary_value,
                'stock'         =>  $key->stock,
                'weight'        =>  $key->weight,
                'fk_category_id'=>  $key->fk_category_id,
            ]);
            
            
        }

    }
}

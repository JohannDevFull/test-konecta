<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $best_selling_product=[];
        $product_with_more_stock=[];
        
        $best_selling_product = DB::select('
            SELECT products.name, SUM(invoices_products.cant) as cantidad
            FROM invoices_products 
            JOIN products ON 
            invoices_products.products_id = products.id
            GROUP BY products.id, products.name
            ORDER BY SUM(invoices_products.cant) DESC LIMIT 1;
        ');

        $product_with_more_stock = Product::orderBy( 'stock' , 'DESC' )
        ->get();

        $clients = Client::all(); 
        $invoices = Invoice::all(); 

        if (isset($best_selling_product[0]))
        {
            $best_selling_product = $best_selling_product[0];
        }

        if (isset($product_with_more_stock[0]))
        {
            $product_with_more_stock = $product_with_more_stock[0];
        }

        return Inertia::render('Welcome', [
            'best_selling_product' => $best_selling_product,
	        'product_with_more_stock' => $product_with_more_stock,
            'clients' => count($clients),
            'invoices' => count($invoices),

            'canLogin' => Route::has('login'),
	        'canRegister' => Route::has('register'),
	        'laravelVersion' => Application::VERSION,
	        'phpVersion' => PHP_VERSION
	    ]);
    }
}

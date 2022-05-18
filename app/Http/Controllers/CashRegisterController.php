<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Konecta/CashRegister', [
	        'canLogin' => Route::has('login')
	    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function clientById($id)
    {

        // sql  XD
        $client=DB::select('SELECT * FROM clients WHERE id = ?', [$id]);

        $client=$client[0];

        return response()->json(compact('client'),201);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Welcome', [
	        'canLogin' => Route::has('login'),
	        'canRegister' => Route::has('register'),
	        'laravelVersion' => Application::VERSION,
	        'phpVersion' => PHP_VERSION
	    ]);
    }
}

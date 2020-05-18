<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItensController extends Controller
{
    public function index() 
    {
    	\Artisan::queue('destiny:database-download');
    }
}

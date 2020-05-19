<?php

namespace App\Http\Controllers;

use App\Util\Destiny;
use App\Util\DB;
use Illuminate\Http\Request;

class ItensController extends Controller
{
    public function index($lang) 
    {
    	$DB = (new DB($lang))->getConnection('sqlite');

    	dd($DB->select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name"));
    }
}

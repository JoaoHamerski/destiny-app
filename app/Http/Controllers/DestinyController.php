<?php

// SELECT name FROM sqlite_master WHERE type='table' ORDER BY name

namespace App\Http\Controllers;

use App\Util\DBHelper;
use App\Util\ApiManager;
use Illuminate\Http\Request;

class DestinyController extends Controller
{

    public function index($lang) 
    {
    	$DB = new DBHelper($lang);
    }
}

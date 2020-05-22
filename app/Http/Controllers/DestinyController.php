<?php

// SELECT name FROM sqlite_master WHERE type='table' ORDER BY name

namespace App\Http\Controllers;

use App\Util\DBHelper;
use Illuminate\Http\Request;
use App\Util\CollectionHelper;

class DestinyController extends Controller
{

    public function index($lang = 'pt-br') 
    {
    	$DB = new DBHelper($lang);

    	dd($DB->tables('DestinyRaceDefinition')->get());

    	return view('index', compact('items'));
    }
}

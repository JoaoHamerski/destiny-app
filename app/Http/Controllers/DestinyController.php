<?php

namespace App\Http\Controllers;

use App\Util\DBHelper;
use Illuminate\Http\Request;
use App\Util\CollectionHelper;

class DestinyController extends Controller
{

    public function index($lang = 'en') 
    {
    	$DBH = new DBHelper($lang);

    	$items = $DBH->where('*', 'json->displayProperties->hasIcon', true)->paginate(24);
    	$item = $DBH->where('*', 'json->hash', 2083630698)->get();

    	// dd(json_decode($item[0]->json));
    	return view('index', compact(['items', 'DBH']));
    }
}

<?php

namespace App\Http\Controllers;

use App\Util\DBHelper;
use Illuminate\Http\Request;
use App\Util\CollectionHelper;

class DestinyController extends Controller
{

    public function index($lang = 'pt-br') 
    {
    	$DBH = new DBHelper($lang);

    	$items = $DBH->where('*', 'json->displayProperties->hasIcon', true)->paginate(24);

    	return view('index', compact(['items', 'DBH']));
    }

    public function show($hash) 
    {
    	$DBH = new DBHelper('pt-br');

    	$item = $DBH->where('*', 'json->hash', (int) $hash)->first();
    	$item = json_decode($item->json);
    	
    	return view('modal', compact('item'));

    	return response()->json(['item' => $item], 200);
    }
}

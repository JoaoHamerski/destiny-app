<?php 

namespace App\Util;

use App\Database;
use App\Util\Destiny;
use Illuminate\Support\Facades\DB as LaravelDB;

class DB extends LaravelDB
{
	protected $destiny;

	public function __construct($lang)
	{
		$this->destiny = new Destiny();
    	config(['database.connections.sqlite.database' => $this->getDatabasePath($lang)]);
	}

	public function getDatabasePath($lang) 
	{
		return $this->destiny->getCachePath($lang) . Database::where('lang', $lang)->first()->filename;
	}

	public function getConnection() 
	{
		return static::connection('sqlite');
	}
}
<?php 

namespace App\Util;

use App\Database;
use App\Util\Destiny;
use Illuminate\Support\Facades\DB as LaravelDB;

class DB extends LaravelDB
{
	protected $destiny;

	public function __construct()
	{
		$this->destiny = new Destiny();
	}

}
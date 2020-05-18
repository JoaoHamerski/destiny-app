<?php 

namespace App\Util;

class Helper
{
	/**
	 * Força a criação dos diretórios caso necessário quando
	 * utilizar a função file_put_contents
	 * 
	 * @param  string  $fullPath
	 * @param  string  $contents
	 * @param  integer  $flags
	 * @return void
	 */
	public static function file_fput_contents($fullPath, $contents, $flags = 0) 
	{
	    $parts = explode('/', $fullPath);

	    array_pop($parts);

	    $dir = implode('/', $parts);
	   
	    if (! is_dir($dir)) {
	        mkdir($dir, 0777, true);
	    }
	   
	    file_put_contents($fullPath, $contents, $flags);
	}
}
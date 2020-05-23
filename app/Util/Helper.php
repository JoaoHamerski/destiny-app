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

	public static function displayDataRecursively($data, &$html = '')
	{
	    foreach($data as $key => $value) {

	        if (is_object($value) || is_array($value)) {
	        	$html .= "<ul class=\"list-group\"> <li class=\"list-group-item\"> $key </li> </ul>";

	            self::displayDataRecursively($value, $html); 
	        } else {
	        	$value = self::resolveData($key, $value);

	        	$html .= "<ul>";
	        	$html .= "<li class=\"list-group-item\"> $key </li>";
	        	$html .= "<li class=\"list-group-item\"> $value </li>";
	        	$html .= "</ul>";
	        }
	    }

	    return $html;
	}

	public static function resolveValue($key, $value)		 
	{
		if ($value === false) {
			return 'false';
		}

		if ($value === true) {
			return 'true';
		}

		if (\Str::endsWith($value, ['.png', '.jpg'])) {
			return '<img src="https://www.bungie.net' . $value . '"/>';
		}

		return $value;
	}

	public static function resolveName($item) 
	{
		$name = json_decode($item->json)->displayProperties->name ?? null;

		if (empty($name)) {
			return '<i> Sem nome </i>';
		}

		return $name ?? '<i> Sem nome </i>';
	}

	public static function resolveDescription($item) 
	{
		$description = json_decode($item->json)->displayProperties->description ?? null;

		if (empty($description)) {
			return '<i> Sem descrição </i>';
		}

		return $description ?? '<i> Sem descrição </i>';
	}

	public static function resolveIcon($item) 
	{
		$icon = json_decode($item->json)->displayProperties->icon ?? null;

		if (empty($icon)) {
			return 'https://www.bungie.net/img/misc/missing_icon_d2.png';
		}

		return $icon ? 'https://www.bungie.net' . $icon : null;
	}
}
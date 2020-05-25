<?php 

namespace App\Util;

class Resolve
{
	public static function key($key) 
	{
		
	}

	public static function value($value)		 
	{
		if ($value === false) {
			return 'false';
		}

		if ($value === true) {
			return 'true';
		}

		if (empty($value)) {

		}

		if (\Str::endsWith($value, ['.png', '.jpg'])) {
			return '<img src="https://www.bungie.net' . $value . '"/>';
		}

		return $value;
	}

	public static function name($item) 
	{
		$name = json_decode($item->json)->displayProperties->name ?? null;

		if (empty($name)) {
			return '<i> Sem nome </i>';
		}

		return $name ?? '<i> Sem nome </i>';
	}

	public static function description($item) 
	{
		$description = json_decode($item->json)->displayProperties->description ?? null;

		if (empty($description)) {
			return '<i> Sem descrição </i>';
		}

		return $description ?? '<i> Sem descrição </i>';
	}

	public static function icon($item) 
	{
		$icon = json_decode($item->json)->displayProperties->icon ?? null;

		if (empty($icon)) {
			return 'https://www.bungie.net/img/misc/missing_icon_d2.png';
		}

		return $icon ? 'https://www.bungie.net' . $icon : null;
	}
}
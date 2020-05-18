<?php 

namespace App\Util;

class Destiny
{
	private $client;
	private $storagePath;
	private $cachePath;

	public function __construct()
	{
		$this->client = resolve(\GuzzleHttp\Client::class);
		$this->storagePath = self::isCLI() 
			? $_SERVER['PWD'] . config('database.sqlite.storage_path')
			: $_SERVER['DOCUMENT_ROOT'] . '/..' . config('database.sqlite.storage_path');

		$this->cachePath = self::isCLI() 
			? $_SERVER['PWD'] . config('database.sqlite.cache_path')
			: $_SERVER['DOCUMENT_ROOT'] . '/..' .  config('database.sqlite.cache_path');
	}

	public static function isCLI() 
	{
		return http_response_code() === false;
	}

	public function getStoragePath($lang)		 
	{
		return $this->storagePath . "$lang/";
	}

	public function getCachePath($lang) 
	{
		return $this->cachePath . "$lang/";
	}

	public function getFilepath($storagePath, $databaseFilepath) 
	{
		return $storagePath . $this->getDatabaseFilename($databaseFilepath) . '.zip';
	}	

	public function getManifest() 
	{
		$response = $this->client->request('GET', 'Destiny2/Manifest');
		$content = $response->getBody()->getContents();

		return json_decode($content);
	}

	public function getStatusCode() 
	{
		$response = $this->client->request('GET', 'Destiny2/Manifest');

		return $content = $response->getStatusCode();
	}

	public function getDatabaseFilepaths() 
	{
		$manifest = $this->getManifest();

		return $manifest->Response->mobileWorldContentPaths;
	}

	public function getDatabaseFilepath($lang) 
	{
		$filepaths = (array) $this->getDatabaseFilepaths();

		return [$lang => $this->getDatabaseFilename($filepaths[$lang])];
	}

	public static function getDatabaseFilename($filepath) 
	{
		return \Str::afterLast($filepath, '/');
	}
}
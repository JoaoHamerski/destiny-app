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
		$this->storagePath = $_SERVER['PWD'] . config('database.sqlite.storage_path');
		$this->cachePath = $_SERVER['PWD'] . config('database.sqlite.cache_path');
	}

	public function getStoragePath($lang)		 
	{
		return $this->storagePath . "/$lang/";
	}

	public function getCachePath($lang) 
	{
		return $this->cachePath . "/$lang/";
	}

	public function getFilepath($storagePath, $dbFilepath) 
	{
		return $storagePath . $this->getDBFilename($dbFilepath) . '.zip';
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

		return [$lang => $this->getDBFilename($filepaths[$lang])];
	}

	public static function getDBFilename($filepath) 
	{
		return \Str::afterLast($filepath, '/');
	}
}
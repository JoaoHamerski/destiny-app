<?php 

namespace App\Util;

class ApiManager
{
	/**
	 * Singleton do GuzzleHttp para requisições http.
	 * 
	 * @var \GuzzleHttp\Client
	 */
	private $client;

	/**
	 * Armazena o caminho absoluto para o diretório storage da aplicação.
	 * 
	 * @var string
	 */
	private $storagePath;

	/**
	 * Armazena o caminho absoluto para o diretório public/cache da aplicação
	 * @var string
	 */
	private $cachePath;

	public function __construct()
	{
		$this->client = resolve(\GuzzleHttp\Client::class);
		$this->storagePath = $this->isCLI() 
			? $_SERVER['PWD'] . config('database.sqlite.storage_dir')
			: $_SERVER['DOCUMENT_ROOT'] . '/..' . config('database.sqlite.storage_dir');

		$this->cachePath = $this->isCLI() 
			? $_SERVER['PWD'] . config('database.sqlite.cache_dir')
			: $_SERVER['DOCUMENT_ROOT'] . '/..' .  config('database.sqlite.cache_dir');
	}

	/**
	 * Verifica se a interface que a função foi chamada é 
	 * linha de comando ou não.
	 * 
	 * @return boolean [description]
	 */
	public function isCLI() 
	{
		return http_response_code() === false;
	}

	/**
	 * Retorna o caminho absoluto para o diretório "storage" da aplicação.
	 * 
	 * @param  string  $lang 
	 * @return string 
	 */
	public function getStoragePath(string $lang)		 
	{
		return $this->storagePath . "$lang/";
	}

	/**
	 * Retorna o caminho absoluto para o diretório "public/cache" da aplicação.
	 * 
	 * @param  string $lang 
	 * @return [type]       [description]
	 */
	public function getCachePath(string $lang) 
	{
		return $this->cachePath . "$lang/";
	}

	public function getFilepath($lang, $databaseFilepath) 
	{
		return $this->getStoragePath($lang) . $databaseFilepath . '.zip';
	}	

	/**
	 * Retorna o manifest do Destiny 2 via API.
	 *  
	 * @return object
	 */
	public function getManifest() 
	{
		$response = $this->client->request('GET', 'Destiny2/Manifest');
		$content = $response->getBody()->getContents();

		return json_decode($content);
	}

	/**
	 * Retorna o status da requisição à API.
	 * 
	 * @return int 
	 */
	public function getStatusCode() 
	{
		$response = $this->client->request('GET', 'Destiny2/Manifest');

		return $content = $response->getStatusCode();
	}

	/**
	 * Retorna os arquivos do banco de dados do Destiny via API.
	 * 
	 * @return object
	 */
	public function getDatabaseFilepaths() 
	{
		$manifest = $this->getManifest();
		$filepaths = (array) $manifest->Response->mobileWorldContentPaths;

		return $filepaths;
	}

	public function getFilename($filepath) 
	{
		return \Str::afterLast($filepath, '/');
	}
}
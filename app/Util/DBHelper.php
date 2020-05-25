<?php 

namespace App\Util;

use App\Database;
use Illuminate\Support\Facades\DB;

class DBHelper
{
    /**
     * Linguagem da base de dados da API
     * 
     * @var  string
     */

    /**
     * Instancia da ApiManager
     * 
     * @var App\Util\ApiManager
     */
    private $apiManager;

    /**
     * Instância da conexão com SQLite
     * 
     * @var Illuminate\Database\SQLiteConnection
     */
    private $DB;

    public function __construct($lang)
    {
        $this->apiManager = new ApiManager();
        $this->setLanguage($lang);
        $this->DB = DB::connection('sqlite');
    }

    /**
     * Database Helper
     * 
     * @return lluminate\Database\SQLiteConnection Conexão com o SQLite
     */
    public function dbh() 
    {
        return $this->DB;
    }

    /**
     * Altera o arquivo de banco de dados da API de acordo com o idioma passado
     * 
     * @param string $lang linguagem
     */
    public function setLanguage($lang) 
    {
        \App::setLocale($lang);
        
        config(['database.connections.sqlite.database' => $this->getDatabaseFilepath($lang)]);
    }

    /**
     * Retorna o caminho absoluto do arquivo de banco de dados da API
     * de acordo com a linguagem passada.
     * 
     * @param  string $lang
     * @return string      
     */
    public function getDatabaseFilepath($lang) 
    {
        $cachePath = $this
            ->apiManager
            ->getCachePath($lang);

        $filename = Database::where('lang', $lang)
            ->first()
            ->filename;

        return $cachePath . $filename;
    }

    /**
     * Retorna uma lista com o nome de todas as tabelas do
     * banco de dados, podendo informar uma chave para o 
     * array da lista.
     * 
     * @param  int $key 
     * 
     * @return Illuminate\Support\Collection 
     */
    public function getAllTableNames($key = null) 
    {
        $tables = $this->DB
                ->table('sqlite_master')
                ->select('name')
                ->where('type', 'table')
                ->orderBy('name')
                ->get()
                ->pluck('name')
                ->toArray();

        return $key ? $tables[$key] : $tables;
    }

    /**
     * Retorna uma query de uma ou várias tabelas
     * unidas.
     * 
     * @param  string $tables
     * 
     * @return Illuminate\Database\Query\Builder
     */
    public function tables($tables) 
    {
        if ($tables === "*") {
            $tables = $this->getAllTableNames();
        }

        if (! is_array($tables)) {
            return $this->DB->table($tables);
        }

        return $this->foreachTables($tables);
    }

    /**
     * Retorna um where de uma ou várias tabelas
     * unidas
     * 
     * @param  string|array $tables  
     * @param  \Closure|string|array  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * 
     * @return Illuminate\Database\Query\Builder
     */
    public function where($tables, $column, $operator = null, $value = null, $boolean = 'and') 
    {
        if ($tables === "*") {
            $tables = $this->getAllTableNames();
        }

        foreach($tables as $key => $table) {
            if ($key === array_key_first($tables)) {
                $query = $this
                    ->DB
                    ->table($table)
                    ->where($column, $operator, $value, $boolean);
            } else {
                $query = $query->union(
                        $this
                        ->DB
                        ->table($table)
                        ->where($column, $operator, $value, $boolean)
                    );
            }
        }

        return $query;
    }

    /**
     * Itera sobre várias tabelas
     * fazendo uma união entre elas.
     * 
     * @param  array $tables
     * 
     * @return Illuminate\Database\Query\Builder
     */
    private function foreachTables($tables)
    {
        foreach($tables as $key => $table) {
            if ($key === array_key_first($tables)) {
                $query = $this->DB->table($table);
            } else {
                $query = $query->union($this->DB->table($table));
            }
        }

        return $query;
    }

    public function getTableNameByHash($hash) 
    {
        $tables = $this->getAllTableNames();

        foreach($tables as $table) {
            if ($this->DB->table($table)->where('json->hash', $hash)->exists()) {
                $str = \Str::of($table)->replace(['Destiny', 'Definition'], '');

                return trim(implode(' ', preg_split('/(?=[A-Z])/', (string) $str)));
            }
        }

        return 'No table';
    }

    /**
     * Converte um valor "hash" para "id" da tabela.
     * 
     * @param  numeric $hash
     * @return int
     */
    public function hashToId($hash) 
    {
        $id = (int) $hash;

        if (($id && (1 << (32 - 1))) != 0) {
          $id = $id - (1 << 32);
        }

        return $id;
    }
}
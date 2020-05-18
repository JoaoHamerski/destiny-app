<?php

namespace App\Console\Commands;

use App\Util\Destiny;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class DestinyDatabaseDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destiny:database-download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download database from Destiny API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $destinyClient = new Destiny();

        if ($destinyClient->getStatusCode() !== 200) {
            $this->error('HTTP ERROR: ' . $destinyClient->getStatusCode());
            die();
        }

        $dbURI = 'https://www.bungie.net';
        $dbFilepaths = $destinyClient->getDatabaseFilepaths();

        $bar = $this->output->createProgressbar(count((array) $dbFilepaths));

        foreach($dbFilepaths as $lang => $dbFilepath) {

            $storagePath = $destinyClient->getStoragePath($lang);
            $filePath = $destinyClient->getFilepath($storagePath, $dbFilepath);

            $this->line('');
            $bar->advance();
            
            $this->info("Downloading \"$lang\" database file...");
            \Helper::file_fput_contents($filePath, file_get_contents($dbURI . $dbFilepath));


            $zip = new \ZipArchive();

            if ($zip->open($filePath) === TRUE) {
                $zip->extractTo($destinyClient->getCachePath($lang));
                $zip->close();
            } else {
                $this->error('Error to extract the file');
            }
        }

        $bar->finish();
        $this->line('');    
    }
}

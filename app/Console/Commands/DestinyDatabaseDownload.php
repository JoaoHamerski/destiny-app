<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use App\Util\ApiManager;
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
        $apiManager = new ApiManager();

        if ($apiManager->getStatusCode() !== 200) {
            $this->error('HTTP ERROR: ' . $apiManager->getStatusCode());
            die();
        }

        $dbURI = 'https://www.bungie.net';
        $dbFilepaths = $apiManager->getDatabaseFilepaths();

        $bar = $this->output->createProgressbar(count((array) $dbFilepaths));

        foreach($dbFilepaths as $lang => $dbFilepath) {

            $storagePath = $apiManager->getStoragePath($lang);
            $filePath = $apiManager->getFilepath($storagePath, $dbFilepath);

            $this->line('');
            $bar->advance();
            
            $this->info("Downloading \"$lang\" database file...");
            \Helper::file_fput_contents($filePath, file_get_contents($dbURI . $dbFilepath));

            $zip = new \ZipArchive();

            if ($zip->open($filePath) === TRUE) {
                $zip->extractTo($apiManager->getCachePath($lang));
                $zip->close();
            } else {
                $this->error('Error to extract the file');
            }

            \DB::table('databases')->updateOrInsert(
                ['lang' => $lang],
                ['filename' => ApiManager::getDatabaseFilename($dbFilepath)]
            );
        }

        $bar->finish();
        $this->line('');    
    }
}

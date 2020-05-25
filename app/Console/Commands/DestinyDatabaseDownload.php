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

        $dbFilepaths = $apiManager->getDatabaseFilepaths();

        $bar = $this->output->createProgressbar(count($dbFilepaths));

        foreach($dbFilepaths as $lang => $filepath) {
            $filename = $apiManager->getFilename($filepath);
            $storageFilepath = $apiManager->getStoragePath($lang) . $filename . '.zip';

            $this->line('');
            $bar->advance();
            $this->info("Downloading \"$lang\" database file...");

            \Helper::file_fput_contents($storageFilepath, file_get_contents('https://www.bungie.net/' . $filepath));

            $zip = new \ZipArchive();

            if ($zip->open($storageFilepath) === TRUE) {
                $zip->extractTo($apiManager->getCachePath($lang));
                $zip->close();
            } else {
                $this->error('Error to extract the file');
            }

            \DB::table('databases')->updateOrInsert(
                ['lang' => $lang],
                ['filename' => $filename]
            );
        }

        $bar->finish();
        $this->line('');    
    }
}

<?php

namespace App\Console\Commands;

use App\Modules\Sync\Sync;
use App\Modules\Sync\Transport\Raspvariant\RaspvariantXML;
use Illuminate\Console\Command;

class ImportRaspvariant extends Command
{
    const IMPORT_MODULE_NAME = RaspvariantXML::SOURCE_NAME;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:raspvariant {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string
     */
    protected $import_file;
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
        $this->info(
            "Import XML starting : '" . static::IMPORT_MODULE_NAME . "' < "
            . $this->argument('file')
        );

        (new Sync(static::IMPORT_MODULE_NAME))
            ->importFile($this->argument('file'));

        $this->info(
            "Import XML finished : '" . static::IMPORT_MODULE_NAME . "' < "
            . $this->argument('file')
        );
    }
}

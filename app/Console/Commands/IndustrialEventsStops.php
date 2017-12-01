<?php

namespace App\Console\Commands;

use App\Models\Transport\Stop;
use App\Modules\Sync\Converter;
use Illuminate\Console\Command;

class IndustrialEventsStops extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'industrial_events:stops {start} {end}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistics: Industrial Event count for Graph';

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
        $stops = Stop::getIndustrialStopsBetween(
            (new Converter)->convertTimeToMinute($this->argument('start')),
            (new Converter)->convertTimeToMinute($this->argument('end'))
        );
        $this->info("All stops between {$this->argument('start')} and {$this->argument('end')} ");
        dump($stops->toArray());

    }
}

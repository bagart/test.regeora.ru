<?php

namespace App\Console\Commands;

use App\Models\Transport\Graph;
use Illuminate\Console\Command;

class IndustrialEventsStat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'industrial_events:stat {graph_num?}';

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
        $graph_query = $this->argument('graph_num')
            ? Graph::where('num', $this->argument('graph_num'))
            : Graph::query();
        $event_count = 0;
        $time_count = 0;
        foreach ($graph_query->get() as $graph) {
            /**
             * @var $graph Graph
             */
            $event_count += $graph->getIndustrialEventCount();
            $time_count += $graph->getIndustrialTimeCount();
        }

        $this->info('Statistics: Industrial Event for '
            . ($this->argument('graph_num') ? '#' . $this->argument('graph_num') : 'All')
            . " Graph is:\nCOUNT: {$event_count}\nTIME: {$time_count} min"
        );
    }
}

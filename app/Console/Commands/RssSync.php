<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Rss\Flux;

class RssSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync RSS flux data';

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
        $fluxes = Flux::all();
        
        dd($fluxes);
    }
    
    public function parseFlux(Flux $rss) {
        
    }
}

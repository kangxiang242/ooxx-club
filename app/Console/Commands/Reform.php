<?php

namespace App\Console\Commands;

use App\Combine\Compose;
use App\Models\Config;
use App\Services\ConfigService;
use App\Services\ImageService;
use Illuminate\Console\Command;

class Reform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:rand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        app(Compose::class)->start();
        $this->info('ok');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Services\ConfigService;
use App\Services\ImageService;
use Illuminate\Console\Command;

class Thumbnail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:resize';

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
        app(ImageService::class)->picture();
        $this->info('ok');

    }
}

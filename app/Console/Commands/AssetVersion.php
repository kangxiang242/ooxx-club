<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Services\ConfigService;
use Illuminate\Console\Command;

class AssetVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asset:update';

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
        $version = app('cache.config')->get('asset_version',0)+1 ;

        Config::updateOrCreate(
            ['name'=>'asset_version'],
            [
                'name'=>'asset_version',
                'content'=>$version,
            ]
        );
        ConfigService::cache();
        $this->info($version);

    }
}

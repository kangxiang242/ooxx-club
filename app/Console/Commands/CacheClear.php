<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Models\Product;
use App\Services\ConfigService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear';

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

        ConfigService::cache();

        Cache::forget('birthplace');

        Cache::forget('category');

        Cache::forget('faq');

        Cache::forget('quick');

        Cache::forget('serve');

        Cache::forget('seo');

        $product = Product::all();
        foreach ($product as $item){
            Cache::forget('goods-'.$item->id);
        }

        $this->info('ok');

    }
}

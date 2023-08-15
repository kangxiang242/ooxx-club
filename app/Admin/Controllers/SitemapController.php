<?php


namespace App\Admin\Controllers;

use App\Models\Config;
use App\Services\ConfigService;
use App\Services\SitemapService;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;
use Rizhou\PageCache\PageCache;

class SitemapController extends AdminController
{
    /**
     * 更新sitemap
     * @return mixed|void
     */
    public function store()
    {
        app(SitemapService::class)->generate();
        admin_toastr('sitemap.xml更新成功', 'success', ['timeOut' => 3000]);
        return redirect(admin_url());
    }

    public function clearRedis(){
        $config = Config::where('name','asset_version')->first();
        if($config){
            $config->content = $config->content+1;
            $config->save();
        }else{
            Config::create([
                'name'=>'asset_version',
                'content'=>'10000',
            ]);
        }

        ConfigService::cache();

        Cache::forget('birthplace');

        Cache::forget('category');

        Cache::forget('faq');

        Cache::forget('quick');

        Cache::forget('serve');


        admin_toastr('缓存清除成功', 'success', ['timeOut' => 3000]);
        return redirect(admin_url());
    }
}

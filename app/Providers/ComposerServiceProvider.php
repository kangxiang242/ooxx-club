<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['web.layout','mobile.layout'],     //模板名
            'App\Http\Composers\LayoutComposer@all'    //方法名或者类中的方法
        );

    }
}

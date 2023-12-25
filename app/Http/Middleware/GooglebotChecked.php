<?php


namespace App\Http\Middleware;


use App\Handlers\DeviceTypeHandlers;
use App\Models\AccessLog;
use App\Services\ConfigService;
use Illuminate\Support\Arr;


class GooglebotChecked
{
    public function handle($request, \Closure $next){

        if($request->path() == '/'){
            $user_agent  = $request->userAgent();
            if(strpos(strtolower($user_agent),'googlebot') !== false){
                $close_googlebot = ConfigService::get('close_googlebot');
                if($close_googlebot){
                    return response('','500');
                }else{
                    $googlebot_index_page = ConfigService::get('googlebot_index_page');
                    if($googlebot_index_page){
                        echo $googlebot_index_page;exit;
                    }
                }

            }

        }

        return $next($request);

    }


}

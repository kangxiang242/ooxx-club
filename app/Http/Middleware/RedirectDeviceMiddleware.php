<?php

namespace App\Http\Middleware;

use App\Handlers\DeviceTypeHandlers;
use App\Services\ConfigService;
use Closure;

class RedirectDeviceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $pc_m_redirect = ConfigService::get('pc_m_redirect',0);
        if($pc_m_redirect){
            $is_mobile = DeviceTypeHandlers::isMobile();


            if($is_mobile){
                $url = config('app.m_url');
            }else{
                $url = config('app.url');
            }

            $parse_url = parse_url($url);
            if($parse_url['host'] != $request->getHost()){
                $n_u = $url.'/'.trim($request->path(),'/');
                return redirect($n_u);
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Handlers\DeviceTypeHandlers;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Inquiry;
use App\Services\SitemapService;
use App\Services\VehicleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{

    public function robots(){
        $config = Config::where('name','robots')->first();
        if($config){
            return response($config->content)->header('Content-type','text/plain');
        }else{
            return response('')->header('Content-type','text/plain');
        }
    }

    public function sitemap(){
        $xml = app(SitemapService::class)->generate();
        return response($xml)->header('Content-type','text/xml');
    }

    public function googleVerify($str){
        //$google_verify_file = app('cache.config')->get('google_verify_file');
        $file = public_path('uploads/google-verify-file/'.'google'.$str.'.html');
        if(file_exists($file)){
            return file_get_contents($file);
        }
        abort(404);
    }

    public function inquiries(Request $request){
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'referer' => 'required',
            'position' => 'required',
        ]);

        if (!$validator->fails()) {
            if($request->type == 'line' || $request->type == 'phone'){
                Inquiry::create([
                    'type'=>$request->type,
                    'referer'=>$request->referer,
                    'position'=>$request->position,
                    'user_agent'=>$request->userAgent(),
                    'ip'=>VehicleService::IP(),
                    'device'=>DeviceTypeHandlers::isMobile()?"mobile":"pc",
                ]);
            }
        }

    }
}

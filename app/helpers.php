<?php

function asset_upload($path='',$default=null){
    //return "https://www.special-fun.com/uploads/".$path;
    return asset('uploads/'.$path);

}

function array_get($array,$key,$default=null){
    return \Illuminate\Support\Arr::get($array,$key,$default);
}

function getMainDomain(){
    $parse_url = parse_url(config('app.url'));
    return array_get($parse_url,'host');
}

function is_mobile_domain(){
    $m_url = config('app.m_url');
    $parse = parse_url($m_url);


    if(array_get($parse,'host') && request()->getHost() == array_get($parse,'host')){

        if(!array_get($parse,'port')){
            return true;
        }else{
            if(array_get($parse,'port') != request()->getPort()){
                return false;
            }
        }
        return true;
    }
    return false;
}

function resize_img($path){
    $wai =explode('.',$path);

    return array_get($wai,0).'-50.'.array_get($wai,1);
}


function get_line_qrcode(){
    $qrcode = explode(',',app('cache.config')->get('line_qrcode'));
    return asset_upload(array_get($qrcode,0));
}
/**
 * 颜色加深算法
 * @param $color
 * @param $amt
 * @return \Dcat\Admin\Support\string|string
 */
function colorDarken($color,$amt){
    $color = str_replace('#', '', $color);

    if (strlen($color) != 6){ return '000000'; }

    $rgb = '';

    for ($x=0;$x<3;$x++){

        $c = hexdec(substr($color,(2*$x),2)) - $amt;

        $c = ($c < 0) ? 0 : dechex($c);

        $rgb .= (strlen($c) < 2) ? '0'.$c : $c;

    }

    return '#'.$rgb;
    //return \Dcat\Admin\Support\Helper::colorDarken($color,$amt);
}

/**
 * 颜色加深算法
 * @param $color
 * @param $amt
 * @return \Dcat\Admin\Support\string|string
 */
function colorAlpha($color,$amt){

    return \Dcat\Admin\Support\Helper::colorAlpha($color,$amt);
}

if (! function_exists('template')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string|null  $view
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $data
     * @param  array  $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function template($view = null, $data = [], $mergeData = []){
        $device = is_mobile_domain()?"mobile":"web";

        return view($device.'.'.$view,$data,$mergeData);
    }
}

function is_mobile(){
    $user_agent = request()->header('user-agent');
    return preg_match("/(Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini)/i", $user_agent);
}



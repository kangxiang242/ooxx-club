<?php


namespace App\Services;


use App\Models\Config;
use Illuminate\Support\Facades\Redis;
class ConfigService
{

    private static $key = "config";

    public static function cache(){
        $config = Config::all();
        Redis::pipeline(function ($pipe) use ($config) {
            foreach($config as $item){
                $pipe->set(self::$key.":{$item->name}", $item->content);
            }
        });
    }

    /**
     * 获取配置值
     * @param $key
     * @param null $default
     * @return mixed
     */
    public static function get($key,$default=null){

        $content = Redis::get(self::$key.':'.$key);

        if(is_null($content)){
            $config = Config::where('name',$key)->first();

            if($config){
                $content = $config->content;
                Redis::set(self::$key.":".$key,$content);
            }
        }

        return is_null($content)?$default:$content;
    }

    /**
     * 替换配置内容
     * @param $content
     * @return string
     */
    public static function replace($content){
        $replace = config('replace');
        foreach ($replace as $key=>$value){
            $config = self::get($value);
            if($config){
                $content = str_replace($key,$config,$content);
            }
        }
        return $content;
    }
}

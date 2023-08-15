<?php


namespace App\Services;


class ArticleService
{
    public static function readingMinuteCount(int $number){
        $minute_number = 300; //每分钟阅读多少字
        $min = $number/$minute_number;

        return self::readingFormat($min);
    }

    public static function readingFormat($min){
        $s = 60/(1/$min);
        $m = $s/60;
        if($m<1){
            return ceil($s)."秒鐘";
        }else{
            return round($m,0)."分鐘";
        }
    }
}

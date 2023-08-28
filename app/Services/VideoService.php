<?php


namespace App\Services;


use App\Models\Video;

class VideoService
{
    public function decompression($pathname){
        $pathinfo = pathinfo($pathname);
        $pathname = public_path('uploads/'.$pathname);
        $extractPath = public_path('uploads/video/'.$pathinfo['filename']);
        if(!is_dir($extractPath)){
            mkdir($extractPath);
        }
        if(file_exists($pathname)){
            $zip = new \ZipArchive;
            $zip->open($pathname);
            $zip->extractTo($extractPath);
            $zip->close();
        }
        $data = $this->scandir($extractPath);
        $this->saveDatabase($data);
        return $data;
    }

    public function scandir($con){

        $filename = scandir($con);
        $path = explode('/',$con);
        $pathname = array_get($path,count($path)-1);

        $data = [];
        foreach($filename as $k=>$v){
            if($v=="." || $v==".."){
                continue;
            }
            $v = strtolower($v);
            if (strpos($v, '.mp4') !== false) {
                $name = substr($v,0,strpos($v,"."));
                $data[] = [
                    'mp4'=>'video/'.$pathname.'/'.$name.'.mp4',
                    'img'=>'video/'.$pathname.'/'.$name.'.jpg',
                ];
            }
        }
        return $data;
    }

    public function saveDatabase($data){
        $insert = [];
        $time = date('Y-m-d H:i:s');
        foreach($data as $item){
            $insert[] = [
                'video'=>$item['mp4'],
                'cover'=>$item['img'],
                'created_at'=>$time,
                'updated_at'=>$time,
            ];
        }
        if($insert){
            Video::insert($insert);
        }

    }
}

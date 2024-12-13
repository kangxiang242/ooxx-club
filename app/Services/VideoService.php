<?php


namespace App\Services;


use App\Models\Video;

class VideoService
{
    public function decompression($pathname,$birthplace_id){
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
        $this->saveDatabase($data,$birthplace_id);
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
                    'img'=>'video/'.$pathname.'/'.$name.'.webp',
                ];
            }
        }
        return $data;
    }

    public function saveDatabase($data,$birthplace_id){
        $insert = [];
        $time = date('Y-m-d H:i:s');
        foreach($data as $item){
            $insert[] = [
                'birthplace_id'=>$birthplace_id,
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

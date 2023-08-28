<?php


namespace App\Services;


use App\Models\Audio;

class AudioService
{
    protected $birthplace_id;

    public function setBirthplaceId($id){
        $this->birthplace_id = $id;
        return $this;
    }

    public function decompression($pathname){
        $pathinfo = pathinfo($pathname);
        $pathname = public_path('uploads/'.$pathname);
        $extractPath = public_path('uploads/audio/'.$pathinfo['filename']);
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
        $getID3 = new \getID3();

        $data = [];
        foreach($filename as $k=>$v){
            if($v=="." || $v==".."){
                continue;
            }
            $v = strtolower($v);
            if (strpos($v, '.mp3') !== false) {
                $name = substr($v,0,strpos($v,"."));
                $mp3 = 'audio/'.$pathname.'/'.$name.'.mp3';
                $ThisFileInfo = $getID3->analyze(public_path('uploads/'.$mp3));
                $fileduration = round($ThisFileInfo['playtime_seconds']);
                $data[] = [
                    'mp3'=>$mp3,
                    'playtime_seconds'=>$fileduration,
                ];
            }
        }
        return $data;
    }

    public function saveDatabase($data){
        $insert = [];
        foreach($data as $item){
            $insert[] = [
                'birthplace_id'=>$this->birthplace_id,
                'audio'=>$item['mp3'],
                'duration'=>$item['playtime_seconds'],
            ];
        }
        if($insert){
            Audio::insert($insert);
        }

    }
}

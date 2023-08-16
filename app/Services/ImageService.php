<?php


namespace App\Services;

use App\Models\Picture;
use \Image;
class ImageService
{

    public function resize($path,$size){
        if(is_file($path)){
            try {
                $img = Image::make($path)->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $saveName = $img->filename.'-small.'.$img->extension;

                $img->save($img->dirname.'/'.$saveName);
            }catch (\Exception $exception){

            }

        }
    }

    public function picture(){
        $pictures = Picture::get();
        foreach($pictures as $pic){
            $images = explode(',',$pic->image);
            foreach($images as $item){
                $path = public_path('uploads/'.ltrim($item,'/'));
                if(file_exists($path)){
                    $this->resize($path,40);
                }
            }
        }
    }

}

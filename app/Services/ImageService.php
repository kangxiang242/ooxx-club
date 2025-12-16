<?php


namespace App\Services;

use App\Models\Picture;
use \Image;
class ImageService
{

    public function resize($path,$size,$type='small',$quality=null){
        if(is_file($path)){
            try {
                $img = Image::make($path)->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $saveName = $img->filename.'-'.$type.'.'.$img->extension;

                $img->save($img->dirname.'/'.$saveName,$quality);
            }catch (\Exception $exception){

            }

        }
    }



}

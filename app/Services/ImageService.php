<?php


namespace App\Services;

use App\Models\Product;
use \Image;
class ImageService
{

    public function resize($path,$size){
        if(is_file($path)){
            try {
                $img = Image::make($path)->resize($size, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $saveName = $img->filename.'-'.$size.'.'.$img->extension;

                $img->save($img->dirname.'/'.$saveName);
            }catch (\Exception $exception){
                dd($exception->getMessage());
            }

        }
    }

    public function resize_product(Product $product){

        foreach ($product->img as $img){
            $path = public_path('uploads/'.ltrim($img,'/'));
            if(file_exists($path)){
                $this->resize($path,50);
            }

        }

    }

}

<?php

namespace App\Admin\Forms;

use App\Models\Audio;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Cookie;

class BatchUploadAudioForm extends Form
{

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        $birthplace_id = Cookie::get('selected_audio_birthplace_id');
        if($birthplace_id && array_get($input,'mp3')){
            $getID3 = new \getID3();
            $insert = [];
            $time = date('Y-m-d H:i:s');
            foreach ($input['mp3'] as $mp3){
                $ThisFileInfo = $getID3->analyze(public_path('uploads/'.$mp3));
                $fileduration = round($ThisFileInfo['playtime_seconds']);
                $insert[] = [
                    'birthplace_id'=>$birthplace_id,
                    'audio'=>$mp3,
                    'duration'=>$fileduration,
                    'created_at'=>$time,
                    'updated_at'=>$time,
                ];
            }
            if($insert){
                Audio::insert($insert);
            }
            //$data = app(AudioService::class)->setBirthplaceId($birthplace_id)->decompression($input['file']);
            return $this
                ->response()
                ->success('音频上传成功，共上传：'.count($insert))
                ->refresh();
        }else{
            return $this
                ->response()
                ->error('上传失败')
                ->refresh();
        }

    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->multipleFile('mp3','文件')->uniqueName()->autoUpload()->move('audio')->maxSize(102400)->help('上傳mp3格式，單次最大100M');

    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [

        ];
    }
}

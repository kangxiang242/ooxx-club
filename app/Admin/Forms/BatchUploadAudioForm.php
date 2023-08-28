<?php

namespace App\Admin\Forms;

use App\Services\AudioService;

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
        if($birthplace_id){
            $data = app(AudioService::class)->setBirthplaceId($birthplace_id)->decompression($input['file']);
            return $this
                ->response()
                ->success('音频导入成功，共导入：'.count($data))
                ->refresh();
        }else{
            return $this
                ->response()
                ->error('导入失败')
                ->refresh();
        }

    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->file('file','文件')->required()->autoUpload()->move('audio/zip')->name(function ($file) {
            return date('Ymd').'-'.md5 (uniqid ()).'.'.$file->guessExtension();
        })->help('请上传zip压缩包，最大100M');

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

<?php

namespace App\Admin\Forms;

use App\Models\Birthplace;
use App\Services\VideoService;
use Dcat\Admin\Widgets\Form;

class BatchUploadVideoForm extends Form
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
        $data = app(VideoService::class)->decompression($input['file'],$input['birthplace_id']);
        return $this
				->response()
				->success('视频导入成功，共导入：'.count($data))
				->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('birthplace_id','茶籍')->options(Birthplace::pluck('name','id'))->required();
        $this->file('file','文件')->required()->autoUpload()->move('videos/zip')->name(function ($file) {
            return date('Ymd').'-'.md5 (uniqid ()).'.'.$file->guessExtension();
        })->accept('zip')->maxSize(102400)->help('请上传zip压缩包，最大100M');

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

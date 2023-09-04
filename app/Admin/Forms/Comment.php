<?php

namespace App\Admin\Forms;




use App\Services\ConfigService;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\DB;

class Comment extends Form
{

    public $title = '客評截圖';

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {

        $comment_picture = array_chunk(explode(',',$input['comment_picture']),100);
        DB::select('TRUNCATE TABLE comments;');
        DB::select('ALTER TABLE comments AUTO_INCREMENT=1;');
        //\App\Models\Comment::delete();
        foreach($comment_picture as $image){
            $insert = [];
            foreach($image as $item){
                $insert[] = [
                    'image'=>$item,
                ];
            }
            \App\Models\Comment::insert($insert);
        }



        return $this
            ->response()
            ->success('Processed successfully.')
            ->refresh();
    }

    public function form()
    {
        Admin::style(<<<STYLE
.form-horizontal{
    display: flex;
    flex-direction: column-reverse;
}
.card .box-footer{
    border-bottom: 1px solid #f4f4f4;
    border-top:none;
}
.card button[type="reset"]{
display:none;
}
.card button[type="submit"]{
    height: 40px;
    width: 100px;
}
.card .web-uploader{
    display: flex;
    flex-direction: column-reverse;
}
.card .web-uploader .statusBar{
    margin-bottom:20px;
}
STYLE
);
        $this->multipleFile2('comment_picture','圖片')->limit(3000)->move('comment')->autoUpload()->uniqueName()->saving(function ($paths){
            return implode(',', $paths);
        });
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return ['comment_picture'=>implode(',',ConfigService::get('comment_picture',null,false))];
        $comment = \App\Models\Comment::pluck('image');
        if($comment){
            return ['comment_picture'=>implode(',',$comment->toArray())];
        }
        return ['comment_picture'=>ConfigService::get('comment_picture',null,false)];
        return [];


    }

}

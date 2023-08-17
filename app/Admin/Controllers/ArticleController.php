<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\ArticleHtmlCode;
use App\Admin\Repositories\Article;
use App\Handlers\ArticleAnchorsHandler;
use App\Models\ArticleCate;
use App\Models\Tag;
use Dcat\Admin\Contracts\UploadField as UploadFieldInterface;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(Article::with(['cate']), function (Grid $grid) {

            $grid->column('cate.name','文章分類');
            $grid->column('title');
            $grid->column('img')->image('','100','100');

            $grid->column('status')->switch();
            $grid->column('sort')->orderable();
            $grid->column('release_at')->sortable();
            $grid->column('created_at')->sortable();

            $grid->quickSearch('title')->placeholder('搜索...');

            $grid->disableRowSelector();
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Article(), function (Show $show) {
            $show->field('id');
            $show->field('article_cate_id');
            $show->field('title');
            $show->field('brief');
            $show->field('img');
            $show->field('img_alt');
            $show->field('read_num');
            $show->field('real_read_num');
            $show->field('content');
            $show->field('sort');
            $show->field('status');
            $show->field('seo_title');
            $show->field('seo_keyword');
            $show->field('seo_description');
            $show->field('release_at');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {


        return Form::make(new Article, function (Form $form) {
            $form->select('article_cate_id','所屬分類')->options(function($id){
                $data = ArticleCate::pluck('name','id');
                return $data;
            })->required()->default(1);

            $form->text('title')->required();

            $form->text('author','作者');

            $form->image('img')->uniqueName()->autoUpload()->move('article');
            $form->text('img_alt');
            $form->number('read_num')->default(1);

            $form->textarea('brief');
            $form->weditor('content','内容')->help('[*BTN*] 短代码插入联络按钮');
            /*$form->radio('mode','模式')->options(['在线编辑器','代码上传'])->when(0,function($form){
                $form->weditor('content','内容')->help('[*BTN*] 短代码插入联络按钮');
            })->when(1,function($form){
                $form->file('html_file','代码上传')->uniqueName()->move('article_html')->autoUpload();
            })->default(0);*/




            $form->hidden('sort');
            $form->radio('status')->options(['1' => '正常', '0'=> '关闭'])->default('1')->required();
            $form->datetime('release_at','發佈時間')->default(date('Y-m-d H:i:s'))->required();

            $form->fieldset('SEO', function (Form $form) {
                $form->text('seo_title');
                $form->text('seo_keyword');
                $form->text('seo_description');
            });




            /*$form->uploaded(function (Form $form, UploadFieldInterface $field, UploadedFile $file, $response) {

                $response = $response->toArray();
                // 文件上传成功
                if ($response['status'] && $field->column() == 'html_file') {
                    // 文件访问地址
                    $name = $response['data']['name'];
                    $key = str_replace('.zip','',$name);

                    $zip = new \ZipArchive();
                    $zip->open(public_path('uploads/article_html/'.$name));
                    $zip->extractTO(public_path('uploads/article_html/'.$key.'/'));
                    file_put_contents(public_path('uploads/article_html/'.$key.'/index.html'),str_replace('index, follow','noindex',file_get_contents(public_path('uploads/article_html/'.$key.'/index.html'))));
                    file_put_contents(public_path('uploads/article_html/'.$key.'/index.html'),"<script>document.domain='".getMainDomain()."'</script>",FILE_APPEND);
                }
            });*/

            $form->disableViewButton();

            $form->footer(function ($footer) {

                // 去掉`重置`按钮
                $footer->disableReset();

                // 去掉`查看`checkbox
                $footer->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();

                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
            });

        });
    }
}

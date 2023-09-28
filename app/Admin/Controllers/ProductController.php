<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Models\Area;
use App\Models\Birthplace;
use App\Models\Category;
use App\Models\Quick;
use App\Models\Serve;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Cache;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(Product::with(['birthplace','city','county']), function (Grid $grid) {
            $grid->column('name');
            $grid->column('cover')->image('',50,50);
            $grid->column('age','年齡 / 身高 / 體重 / 罩杯')->display(function(){
                return $this->age.' / '.$this->height.' / '.$this->weight.' / '.$this->cup;
            });

            $grid->column('birthplace.name','茶籍');

            $grid->column('area_city','地區')->display(function(){
                return $this->city->name.$this->county->name;
            });

            $grid->column('outgoing','外送/定點')->display(function (){
                $html = '';
                if($this->outgoing){
                    $html .= '<span class="label" style="background:#586cb1;margin-right: 10px">外送</span>';
                }
                if($this->fixation){
                    $html .= '<span class="label" style="background:#586cb1">定點</span>';
                }
                return $html;
            });
            $grid->column('sham','產品源')->using(['自建','隨機'])->label([
                0 => '#5386be',
                1 => 'primary',
            ]);
            $grid->column('status')->switch();
            $grid->async();

            $grid->selector(function (Grid\Tools\Selector $selector) {
                $selector->selectOne('sham', '產品來源', ['自建','隨機']);
            });
            $grid->quickSearch(['name']);
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('cover');
            $show->field('age');
            $show->field('height');
            $show->field('weight');
            $show->field('cup');
            $show->field('area_city');
            $show->field('area_county');
            $show->field('area_icon');
            $show->field('video');
            $show->field('audio');
            $show->field('sort');
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
        Admin::style(<<<STYLE
        .jstree-container-ul{
            display: flex;
        }
STYLE
);
        return Form::make(Product::with(['withServes','addedServes','prices','quicks','category']), function (Form $form) {
            $form->tab('基本', function (Form $form) {
                $form->text('name')->required();
                $form->hidden('cover');
                $form->multipleImage('picture','相片')->sortable()->autoUpload()->uniqueName()->thumbnail('small',20,20*1.066)->saving(function ($paths){
                    return implode(',', $paths);
                })->required();
                $form->number('age')->min(0)->required();
                $form->number('height')->min(0)->required();
                $form->number('weight')->min(0)->required();
                $form->radio('cup')->options([
                    'C'=>'C','D'=>'D','E'=>'E','G'=>'G+'
                ])->required();
                $form->select('birthplace_id')->options(Birthplace::pluck('name','id'))->required();
                $form->select('area_city','市')->options('/api/get-city')->load('area_county','/api/get-county')->required();
                $form->select('area_county','區')->required();

                $form->tree('category','分類')
                    ->nodes(Category::get()->toArray())
                    ->customFormat(function ($v) { // 格式化外部注入的值
                        if (!$v) return [];
                        return array_column($v, 'id');
                    })->required();

                $form->multipleSelect('quicks','快捷區')->options(Quick::pluck('text','id'))->customFormat(function ($v) {
                    if (!$v) {
                        return [];
                    }
                    return array_column($v, 'id');
                });


                $form->switch('outgoing');
                $form->switch('fixation');
                $form->hidden('price_start')->default(0);
                $form->hidden('price_end')->default(0);
                $form->hidden('status')->default(1);
                $form->hidden('is_top')->default(0);
            })->tab('定价',function (Form $form){
                $form->hasMany('prices', function (Form\NestedForm $form) {
                    $form->text('text','标题');
                    $form->decimal('price','价格');
                });


            })->tab('服務',function (Form $form){
                $form->checkbox('withServes')->options(Serve::pluck('name','id'))->customFormat(function ($v) {
                    if (! $v) {
                        return [];
                    }
                    return array_column($v, 'id');
                });

                $form->checkbox('addedServes')->options(Serve::pluck('name','id'))->customFormat(function ($v) {
                    if (! $v) {
                        return [];
                    }
                    return array_column($v, 'id');
                });

            })->tab('媒體',function (Form $form){

                $form->file('video')->autoUpload()->uniqueName()->retainable()->accept('mp4')->chunkSize(256)->threads(4);
                $form->image('video_cover','視頻封面')->move('video')->autoUpload()->uniqueName();
                $form->file('audio')->autoUpload()->uniqueName()->retainable()->accept('mp3')->chunkSize(256)->threads(2);
                $form->multipleImage('comment_picture')->sortable()->autoUpload()->uniqueName()->thumbnail('small',20,35.84)->saving(function ($paths){
                    return implode(',', $paths);
                });

            });



            $form->saving(function (Form $form) {
                if($form->picture){
                    $form->cover = array_get(explode(',',$form->picture),0); //设置第一张为封面
                }
                if($form->prices){
                    $prices = array_values($form->prices);
                    $form->price_start = array_get($prices,'0.price');

                    $form->price_end = array_get($prices,(count($prices)-1).'.price');
                }

                if($form->audio){
                    $getID3 = new \getID3();
                    $ThisFileInfo = $getID3->analyze(public_path('uploads/'.$form->audio));
                    $fileduration = round($ThisFileInfo['playtime_seconds']);
                    $form->audio_time = $fileduration;
                }
                dd($form->audio,$ThisFileInfo,$form->audio_time);


            });

            $form->saved(function (Form $form, $result) {
                Cache::forget('goods-'.$result);
            });

        });
    }
}

<?php

namespace App\Admin\Forms;



use App\Models\Birthplace;
use App\Models\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Form\NestedForm;

class Nahw extends Config
{

    public $title = 'NPC配置';

    public function form()
    {
        $this->tab('人物參數',function (){
            $this->textarea('nickname','名字')->rows(20)->help('空格为一条');
            $this->textarea('nickname_western','欧美名字')->rows(20)->help('空格为一条');

            $this->range('age_start','age_end','年齡隨機範圍');

            $this->range('height_start','height_end','身高隨機範圍(cm)');

            $this->range('weight_start','weight_end','體重隨機範圍(kg)');

            /*$this->text('fixation_price','定點價格隨機');

            $this->text('outgoing_price','外送價格隨機');*/

        })->tab('組合規則',function (){

            $this->array('rules','分類匹配規則', function (NestedForm $table) {
                $table->select('field','字段')->options(Category::where('parent_id','>',0)->pluck('name','id'))->required();
                $table->select('operator','運算符')->options(['>='=>'>=','<='=>'<=','='=>'=','random'=>'隨機以下各項'])->required();
                $table->select('mate','匹配项')->options(['height'=>'身高','weight'=>'体重','age'=>'年龄','cup'=>'罩杯','price'=>'價格','quick'=>'快捷']);
                $table->text('value','值');
            })->useTable();


            $this->array('birthplace_rules','茶籍分類互斥', function (NestedForm $table) {
                $table->select('field','字段')->options(Birthplace::where('status',1)->pluck('name','id'))->required();
                $table->select('operator','運算符')->options(['except'=>'排除以下各項'])->required();
                $table->multipleSelect('value','值')->options(Category::where('parent_id','>',0)->pluck('name','id'));
            })->useTable();
        });




    }

}

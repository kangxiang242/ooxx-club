<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Article extends Model implements Sortable
{
    use HasDateTimeFormatter,SortableTrait,HasFactory;

    protected $dates = ['delete_at','release_at'];

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'sort',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    public function cate()
    {
        return $this->belongsTo(ArticleCate::class,'article_cate_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'article_tags');
    }

}

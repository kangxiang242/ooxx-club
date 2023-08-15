<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Traits\HasDateTimeFormatter;
class ArticleCate extends Model
{
    use HasDateTimeFormatter;

    /**
     * 获取博客文章的评论
     */
    public function article()
    {
        return $this->hasMany(Article::class);
    }

}

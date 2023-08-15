<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;

class Area extends Model implements Sortable
{
    use HasFactory,
        HasDateTimeFormatter,
        ModelTree{
        allNodes as treeAllNodes;
        ModelTree::boot as treeBoot;
    }

    protected $titleColumn = 'name';

    protected $orderColumn = 'sort';

    protected $parentColumn = 'parent_id';

    protected $sortable = [
        // 设置排序字段名称
        'order_column_name' => 'sort',
        // 是否在创建时自动排序，此参数建议设置为true
        'sort_when_creating' => true,
    ];

    public function sub()
    {
        return $this->hasMany(Area::class, 'parent_id', 'id')->orderBy('sort','asc');
    }

    public function parent()
    {
        return $this->hasOne(Area::class, 'id', 'parent_id');
    }
}

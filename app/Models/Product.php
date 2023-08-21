<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Resizable;
class Product extends Model
{
    use HasFactory,HasDateTimeFormatter,Resizable;

    protected $fillable = [
        'birthplace_id','name','cover','age','height','weight','cup','area_city','area_county','price_start','price_end','picture','comment_picture','video','video_cover','audio','audio_time','sort','status','sham','outgoing','fixation','type'
    ];

    /**
     * 可加值服務
     */
    public function category()
    {
        return $this->belongsToMany(Category::class,'product_categories','product_id','category_id');
    }

    /**
     * 可配合服務
     */
    public function withServes()
    {
        return $this->belongsToMany(Serve::class,'product_with_serves');
    }

    /**
     * 可加值服務
     */
    public function addedServes()
    {
        return $this->belongsToMany(Serve::class,'product_added_serves');
    }

    /**
     * 快捷
     */
    public function quicks()
    {
        return $this->belongsToMany(Quick::class,'product_quicks');
    }

    /**
     * 价格
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * 茶籍
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function birthplace()
    {
        return $this->belongsTo(Birthplace::class);
    }

    /**
     * 市
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(Area::class,'area_city')->where('level',1);
    }

    /**
     * 區
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function county()
    {
        return $this->belongsTo(Area::class,'area_county')->where('level',2);
    }
}

<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Resizable;
class Product extends Model
{
    use HasDateTimeFormatter,Resizable;

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


    /**
     * Method for returning specific thumbnail for model.
     *
     * @param  string  $type
     * @param  string  $attribute
     * @return string|null
     */
    public function thumbnail($type, $attribute = 'image', $disk = null)
    {
        // Return empty string if the field not found
        if (! isset($this->attributes[$attribute])) {
            $image = $attribute;
        }else{
            // We take image from posts field
            $image = $this->attributes[$attribute];
        }

        $thumbnail = $this->getThumbnailPath($image, $type);

        //$thumbnail = str_replace('watermark/','',$thumbnail);

        return file_exists(public_path('uploads/'.$thumbnail)) ? $thumbnail : $image;
    }
}

<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory,HasDateTimeFormatter;

    protected $fillable = [
        'video','cover','status','birthplace_id'
    ];

    public function birthplace()
    {
        return $this->belongsTo(Birthplace::class);
    }
}

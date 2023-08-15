<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory,HasDateTimeFormatter;

    protected $fillable = [
        'type','referer','position','user_agent','ip','device'
    ];
}

<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    use HasDateTimeFormatter;

    protected $fillable = [
        'ip','ip_country','status_code','message','uri','method','user_agent','parameters','headers','trace','referer'
    ];

    protected $casts = [
        'parameters'=>'json','headers'=>'json','trace'=>'json'
    ];

}

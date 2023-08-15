<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddedServe extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id','serve_id'
    ];

    public function serve()
    {
        return $this->belongsTo(Serve::class);
    }
}

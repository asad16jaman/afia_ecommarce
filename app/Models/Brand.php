<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    protected $table = 'tbl_brand';
    protected $primaryKey = 'brand_SiNo';
    public $timestamps = false;

    protected $guarded = [];
    
}

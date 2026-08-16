<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //

    protected $table = 'tbl_banners';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $guarded = [];
}

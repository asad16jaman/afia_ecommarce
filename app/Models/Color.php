<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //

    protected $table = 'tbl_color';
    protected $primaryKey = 'Color_SlNo';
    public $timestamps = false;

    protected $guarded = [];
}
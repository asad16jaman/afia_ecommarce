<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //

    protected $table = 'tbl_size';
    protected $primaryKey = 'Size_SlNo';
    public $timestamps = false;

    protected $guarded = [];
}
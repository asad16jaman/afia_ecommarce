<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    //

    protected $table = 'tbl_galleries';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $guarded = [];
}
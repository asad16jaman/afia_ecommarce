<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traking extends Model
{
    //

    protected $table = 'tbl_tracking_scripts';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
}
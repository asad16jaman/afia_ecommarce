<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    //
    protected $table = 'tbl_policies';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

}
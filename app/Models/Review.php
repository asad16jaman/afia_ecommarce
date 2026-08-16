<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    protected $table = 'tbl_review';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];
}
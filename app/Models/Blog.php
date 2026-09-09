<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'tbl_blogs';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $guarded = [];
}
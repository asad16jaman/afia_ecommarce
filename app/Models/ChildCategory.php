<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    //

    protected $table = 'tbl_child_categories';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];


}

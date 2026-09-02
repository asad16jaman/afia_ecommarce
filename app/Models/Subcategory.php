<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    //

    protected $table = 'tbl_subcategories';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];


}

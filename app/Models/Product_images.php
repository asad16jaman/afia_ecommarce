<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_images extends Model
{
    //

    protected $table = 'tbl_product_images';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $guarded = [];
}
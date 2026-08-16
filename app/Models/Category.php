<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $table = 'tbl_productcategory';
    protected $primaryKey = 'ProductCategory_SlNo';
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(
            Product::class,
            'ProductCategory_ID',
            'ProductCategory_SlNo'
        );
    }
    
    protected $guarded = [];
}
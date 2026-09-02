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

    public function subcategories(){
        return $this->hasMany(Subcategory::class,'category_id','ProductCategory_SlNo');
    }
    
    protected $guarded = [];
}
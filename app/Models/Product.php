<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $table = 'tbl_product';
    protected $primaryKey = 'Product_SlNo';
    public $timestamps = false;

    public function product_images(){
         return $this->hasMany(Product_images::class,'product_id','Product_SlNo');
    }

    public function category(){
        return $this->belongsTo(Category::class,'ProductCategory_ID','ProductCategory_SlNo');
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'sub_categori_id','id');
    }

    public function p_brand(){
        return $this->belongsTo(Brand::class, 'brand', 'brand_SiNo');
    }


    protected $guarded = [];
}
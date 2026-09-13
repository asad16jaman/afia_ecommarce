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

    public function childcategories(){
        return $this->hasMany(ChildCategory::class,'subcategory_id','id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id','ProductCategory_SlNo');
    }


}

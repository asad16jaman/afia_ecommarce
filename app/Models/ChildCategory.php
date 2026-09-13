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

    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'subcategory_id','id');
    }


}

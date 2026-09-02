<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customerreview extends Model
{
    //
    protected $table = 'tbl_customer_review';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class,'Customer_SlNo','Customer_SlNo',);
    }
}

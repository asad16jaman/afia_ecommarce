<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = 'tbl_saledetails';
    protected $primaryKey = 'SaleDetails_SlNo';
    public $timestamps = false;
    protected $fillable = ['Product_IDNo', 'SaleMaster_IDNo', 'SaleDetails_Rate', 'SaleDetails_TotalQuantity', 'SaleDetails_TotalAmount'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'SaleMaster_IDNo', 'SaleMaster_SlNo');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'Product_IDNo', 'Product_SlNo')->select('Product_SlNo', 'Product_Code', 'Product_Name', 'Product_Purchase_Rate','Product_MinimumSellingPrice','discount', 'Product_SellingPrice');
    }

    public function size(){
        return $this->belongsTo(Size::class,'size_id','Size_SlNo')->select('Size_Name','Size_SlNo');
    }

}

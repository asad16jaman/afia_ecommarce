<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\OrderDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;
    protected $table = 'tbl_salesmaster';
    protected $primaryKey = 'SaleMaster_SlNo';
    public $timestamps = false;

    protected $fillable = ['SalseCustomer_IDNo', 'SaleMaster_InvoiceNo', 'SaleMaster_Freight', 'SaleMaster_SubTotalAmount'];

    // customer relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'SalseCustomer_IDNo', 'Customer_SlNo');
    }
    // customer relationship
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'SaleMaster_IDNo', 'SaleMaster_SlNo');
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function generateSalesInvoice()
    {
        $branchId = Auth::guard('customer')->user()->branch_id;

        $branchNo = strlen($branchId) < 10 ? '0' . $branchId : $branchId;
        $invoice = date('y') . $branchNo . "00001";
        $year = date('y');
        $sales = Order::where('SaleMaster_InvoiceNo', 'LIKE', "%{$year}%")
            ->where('branch_id', $branchId)
            ->get();
        if (count($sales) != 0) {
            $newSalesId = count($sales) + 1;
            $zeros = array('0', '00', '000', '0000');
            $invoice = date('y') . $branchNo . (strlen($newSalesId) > count($zeros) ? $newSalesId : $zeros[count($zeros) - strlen($newSalesId)] . $newSalesId);
        }
        return $invoice;
    }
}



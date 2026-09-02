<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customerreview;
use App\Models\Order;
use App\Models\OrderDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //

    function registration(){
        return view('front.pages.register');
    }
    function customerRegistration(Request $request){

        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'nullable|email|unique:tbl_customer,Customer_Email',
            'phone' => 'required|regex:/^01[1-9][\d]{8}$/|digits:11|unique:tbl_customer,Customer_Mobile',
            'password' => 'required|confirmed|min:6',
        ]);

        $customer = new Customer();
        $code = 'C' . $this->generateCode('Customer');
        $customer->Customer_Name = $request->name;
        $customer->Customer_Email = $request->email;
        $customer->Customer_Code = $code;
        $customer->Customer_Type = 'customer';
        $customer->Customer_Mobile = $request->phone;
        $customer->Customer_Phone = $request->phone;
        $customer->Customer_Address = 'Need To Set';
        $customer->password = Hash::make($request->password);
        $customer->last_update_ip = $request->ip();
        $customer->AddBy = 1;
        $customer->branch_id = '1';
        $customer->save();

        return redirect()->route('customer.login')->with('success',"Successfully Registration Done");

    }

    function loginCustomer(){
        return view('front.pages.customerlogin');
    }
    function loginCheck(Request $request){

        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'Customer_Email' : 'Customer_Mobile';

        // $credentiads = $request->only('login', 'password');
        if (Auth::guard('customer')->attempt([$fieldType => $login, 'password' => $request->password])) {
            $notification = array(
                'message' => 'Login Successfully',
                'alert-type' => 'success'
            );
            return redirect()->intended('/profile')->with($notification);
        }
        return redirect()->back()
            ->withInput($request->only('login'))
            ->with('error', 'Email or Phone Password was invalid.');

    }

    function profile()
    {

        return view('front.pages.profile');
    }

    function dashboard(){
        $total_order = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $p_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'p')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $a_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'a')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $c_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'd')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        return view('front.pages.dashboard',compact('total_order','p_orders','a_orders','c_orders'));
    }

    function updateCustomer(Request $request){

        $validationRules = [
            'Customer_Name' => [
                'required',
                'string',
                'max:100',
            ],
            'Customer_Mobile' => [
                'required',
                'regex:/^01[3-9]\d{8}$/',
            ],
            'Customer_Email' => [
                'required',
                'email',
                'max:150',
            ],
            'Customer_Address' => [
                'required',
                'string',
                'max:150',
            ],
            'web_profile' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];

        if ($request->filled('password')) {

            $validationRules['current_password'] = [
                'required',
            ];

            $validationRules['password'] = [
                'required',
                'string',
                'min:8',
            ];

            $validationRules['confirm_password'] = [
                'required',
                'same:password',
            ];
        }

        $validation_message = [
            // Customer Name
            'Customer_Name.required' => 'আপনার নাম লিখুন।',
            'Customer_Name.string' => 'নাম অবশ্যই সঠিক হতে হবে।',
            'Customer_Name.max' => 'নাম সর্বোচ্চ ১০০ অক্ষরের হতে পারবে।',
            // Customer Mobile
            'Customer_Mobile.required' => 'আপনার মোবাইল নাম্বার লিখুন।',
            'Customer_Mobile.regex' => 'সঠিক বাংলাদেশি মোবাইল নাম্বার দিন।',
            // Customer Email
            'Customer_Email.required' => 'আপনার ইমেইল লিখুন।',
            'Customer_Email.email' => 'সঠিক ইমেইল ঠিকানা দিন।',
            'Customer_Email.max' => 'ইমেইল সর্বোচ্চ ১৫০ অক্ষরের হতে পারবে।',
            // Customer Address
            'Customer_Address.required' => 'আপনার সম্পূর্ণ ঠিকানা লিখুন।',
            'Customer_Address.string' => 'ঠিকানা অবশ্যই সঠিক হতে হবে।',
            'Customer_Address.max' => 'ঠিকানা সর্বোচ্চ ১৫০ অক্ষরের হতে পারবে।',
            // Profile Image
            'web_profile.image' => 'সঠিক একটি ছবি নির্বাচন করুন।',
            'web_profile.mimes' => 'ছবির ফরম্যাট অবশ্যই JPG, JPEG, PNG অথবা WEBP হতে হবে।',
            'web_profile.max' => 'ছবির সাইজ সর্বোচ্চ ২ MB হতে পারবে।',
            // Current Password
            'current_password.required' => 'বর্তমান পাসওয়ার্ড লিখুন।',
            // New Password
            'password.required' => 'নতুন পাসওয়ার্ড লিখুন।',
            'password.string' => 'নতুন পাসওয়ার্ড অবশ্যই সঠিক হতে হবে।',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            // Confirm Password
            'confirm_password.required' => 'নতুন পাসওয়ার্ডটি আবার লিখুন।',
            'confirm_password.same' => 'নতুন পাসওয়ার্ড এবং নিশ্চিত পাসওয়ার্ড মিলছে না।',
        ];
        $request->validate( $validationRules, $validation_message);

        $customer = Auth::guard('customer')->user();

        if($request->filled('password')){
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->with('error', "Current Password Not Match");
            }
        }
        $data = $request->only(['Customer_Name','Customer_Email','Customer_Mobile','Customer_Address']);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $customer->password)) {
                return back()->with('error', "Current Password Not Match");
            }
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('web_profile')) {
            if ($customer->web_profile && file_exists(public_path($customer->web_profile))) {
                unlink(public_path($customer->web_profile));
            }
            $imageFile = $request->file('web_profile');
            $imageName = $this->uploadImg($imageFile, 'uploads/profile');
            $imagePath = 'uploads/profile/' . $imageName;
        }
        $data['web_profile'] = $imagePath;

        Customer::where('Customer_SlNo', $customer->Customer_SlNo)->update($data);
        return back()->with('success',"Successfully Updated Your Profile.");
        
    }

    function allOrders(){
        $query = request('status');

        $sql_query = Order::select('SaleMaster_SlNo','SaleMaster_InvoiceNo','SaleMaster_TotalSaleAmount',
        'SaleMaster_Description', 'AddTime','status')
        ->where('SalseCustomer_IDNo',Auth::guard('customer')->user()->Customer_SlNo)
        ->where('sales_from','web')
        ->where('DeletedTime',null)
        ->where('DeletedBy',null)
        ;
        $status = '';
        if($query == 'pending'){
            $status = 'p';
        }elseif($query == 'confirmed'){
            $status = 'a';
        }elseif($query == 'cancel'){
            $status = 'd';
        }elseif($query == 'processing'){
            $status = 'pr';
        } elseif ($query == 'shipping') {
            $status = 's';
        }else {
          $status = null;
        };
        if($status){
            $sql_query = $sql_query->where('status',$status);
        }
        $allorders = $sql_query->latest('SaleMaster_SlNo', 'asc')->simplePaginate(20);

        $total_order = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
        ->user()->Customer_SlNo)->where('sales_from', 'web')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();

        $p_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
        ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status','p')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $pr_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'pr')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $sip_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 's')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();

        $a_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
        ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status','a')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();

        $c_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
        ->user()->Customer_SlNo)->where('sales_from', 'web')->where('is_canceled','yes')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
            
        return view('front.pages.all_orders',compact('allorders','total_order','p_orders','a_orders','c_orders','pr_orders','sip_orders'));
    }



    function userLogout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success',"You are logout");
    }

    public function destroy_order($id){
        try{
            $sales_master = Order::where('SaleMaster_SlNo', $id)->firstOrFail();
            if ($sales_master->status != 'p') {
                return response()->json([
                    'status' => true,
                    'message' => 'You cannot delete this order.'
                ]);
            }
            // $sales_master->update([
            //     'DeletedBy' => Auth::guard('customer')->user()->Customer_SlNo,
            //     'DeletedTime' => now()
            // ]);

            $sales_master->DeletedBy = Auth::guard('customer')->user()->Customer_SlNo;
            $sales_master->DeletedTime = now();
            $sales_master->save();
            OrderDetails::where('SaleMaster_IDNo', $sales_master->SaleMaster_SlNo)->update([
                'DeletedBy' => Auth::guard('customer')->user()->Customer_SlNo,
                'DeletedTime' => now()
            ]);
            return response()->json([
                'status' => true,
                'd-message' => null,
                'message' => "Order Deleted Successfully!"
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => false,
                'd-message' => $e->getMessage(),
                'message' => "There is a problem"
            ]);
        }
    }

    public function order_invoice($id){


        $orders = Order::with(['customer'=>function($query){
            $query->select('Customer_SlNo','Customer_Code','Customer_Name','Customer_Mobile','Customer_Address','Customer_Email');
        },'orderDetails'=>function($q){
            $q->select('SaleDetails_SlNo','SaleMaster_IDNo','Product_IDNo','size_id','SaleDetails_TotalQuantity','SaleDetails_Rate','SaleDetails_TotalAmount');
        },'orderDetails.product','orderDetails.size'])->select('SaleMaster_SlNo','status','AddTime','SaleMaster_SubTotalAmount','SaleMaster_Freight','SaleMaster_TotalSaleAmount','SalseCustomer_IDNo','SaleMaster_InvoiceNo')->where('SaleMaster_SlNo',$id)->firstOrFail();
        
        

        // return response()->json($orders);

        $total_order = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $p_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'p')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $a_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'a')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();
        $c_orders = Order::where('SalseCustomer_IDNo', Auth::guard('customer')
            ->user()->Customer_SlNo)->where('sales_from', 'web')->where('status', 'd')->where('DeletedTime', null)
            ->where('DeletedBy', null)->count();

        return view('front.pages.invoice',compact('orders','total_order','p_orders','a_orders','c_orders'));
    }

    public function storeReview(Request $request){
        $valid_rules = [
            'stars' => "required|int|min:1|max:5",
            'review' => "required|string|max:255",
        ];

        if(empty($request->Product_SlNo)){
            $valid_rules['name'] = "required|string:max:100";
            $valid_rules['address'] = "required|string:max:200";
            $valid_rules['phone'] = "required";
        }else{
            $valid_rules['Product_SlNo'] = "required";
        }

        $checking = Validator::make($request->all(),$valid_rules);
        if($checking->fails()){
            return response()->json([
                'status' => false,
                'errormessage' => "There is a problem"
            ]);
        }

        $data = [
            'rating' => $request->stars,
            'review' => $request->review,
            'phone' => $request->phone,
            'address' => $request->address,
            'name' => $request->name,
            'status' => 'p',
            'Product_SlNo' => $request->Product_SlNo,
            'Customer_SlNo' => $request->Customer_SlNo
        ];
        Customerreview::create($data);

        return response()->json([
            'status' => true,
            'message' => "Successfully stored message"
        ]);

    }

    public function getAllReview(Request $request) {

        $reviews = Customerreview::with(['customer' => function ($q) {
            $q->select('Customer_Name','Customer_Code','Customer_SlNo','web_profile');
        }])->where('status','a')->where('Product_SlNo',$request->Product_SlNo)->whereNull('deleted_at')->simplePaginate(10);
        
        return response()->json([
            'status' => true,
            'data' => $reviews
        ]);
    }



}

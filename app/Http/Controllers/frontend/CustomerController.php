<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        return view('front.pages.dashboard');
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
            'image' => [
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
            'image.image' => 'সঠিক একটি ছবি নির্বাচন করুন।',
            'image.mimes' => 'ছবির ফরম্যাট অবশ্যই JPG, JPEG, PNG অথবা WEBP হতে হবে।',
            'image.max' => 'ছবির সাইজ সর্বোচ্চ ২ MB হতে পারবে।',
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
        Customer::where('Customer_SlNo', $customer->Customer_SlNo)->update($data);
        return back()->with('success',"Successfully Updated Your Profile.");
        
    }

    function allOrders(){
        return view('front.pages.all_orders');
    }



    function userLogout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login')->with('success',"You are logout");
    }




}

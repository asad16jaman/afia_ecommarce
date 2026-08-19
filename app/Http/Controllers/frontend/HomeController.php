<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\StockHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Review;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //

    public function index()
    {
        $sliders = Slider::where('status','a')->get();
        $banner = Banner::first();
        $categories = Category::select('ProductCategory_SlNo','ProductCategory_Name','image')->where('status','a')->get();
        $newArrivals = Product::select('Product_SlNo','Product_Code','Product_Name','slug','Product_SellingPrice','Product_MinimumSellingPrice','discount','thum_image')
        ->where('new_arrival',1)->where('status','a')->get();
        $newArrivals = $newArrivals->map(function($el){
            $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);;
            $current_stock = StockHelper::getProductStock($el->Product_SlNo);;
            $el->size_wise_stock = $size_wise_stock;
            $el->current_stock = $current_stock;
            return $el;
        });
        $popular_roduct = Product::select('Product_SlNo', 'Product_Code','Product_Name', 'slug','Product_SellingPrice','Product_MinimumSellingPrice','discount','thum_image')
        ->where('popular_product',1)->where('status','a')->get();
        $popular_roduct = $popular_roduct->map(function ($el) {
            $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
            ;
            $current_stock = StockHelper::getProductStock($el->Product_SlNo);
            ;
            $el->size_wise_stock = $size_wise_stock;
            $el->current_stock = $current_stock;
            return $el;
        });
        $products = Product::select('Product_SlNo', 'Product_Code','Product_Name', 'slug','Product_SellingPrice','Product_MinimumSellingPrice','discount','thum_image')
        ->where('status','a')->inRandomOrder()->take(20)->get();

        $products = $products->map(function ($el) {
            $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
            $current_stock = StockHelper::getProductStock($el->Product_SlNo);
            $el->size_wise_stock = $size_wise_stock;
            $el->current_stock = $current_stock;
            return $el;
        });
        $reviews = Review::select('id','image','title')->where('status','a')->get();
       return view('front.pages.home',compact('sliders','banner','categories','newArrivals','popular_roduct','products','reviews'));
    }


    public function allproducts(){

        $categories = Category::select('ProductCategory_SlNo', 'ProductCategory_Name', 'image')
        ->where('status', 'a')->get();
        $min = Product::min('Product_MinimumSellingPrice');
        $max = Product::max('Product_MinimumSellingPrice');
        return view('front.pages.shop',compact('categories','max','min'));
    }

    public function getProducts(Request $request)
    {
        $products = Product::select(
            'Product_SlNo',
            'Product_Code',
            'Product_Name',
            'slug',
            'Product_SellingPrice',
            'Product_MinimumSellingPrice',
            'discount',
            'thum_image'
        )->where('status', 'a')
        ->when(!empty($request->categories), function ($query) use ($request) {
                $query->whereIn('ProductCategory_ID', $request->categories);
            })
        ->when($request->filled('min'), function ($query) use ($request) {
                $query->where(
                    'Product_MinimumSellingPrice',
                    '>=',
                    $request->min
                );
            })
        ->when($request->filled('max'), function ($query) use ($request) {
                $query->where(
                    'Product_MinimumSellingPrice',
                    '<=',
                    $request->max
                );
            })
            ->inRandomOrder()
            ->paginate(18);
        $products->getCollection()->transform(function ($el) {
            $el->size_wise_stock = StockHelper::getSizeWiseStock(
                $el->Product_SlNo
            );
            $el->current_stock = StockHelper::getProductStock(
                $el->Product_SlNo
            );
            return $el;
        });

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    public function getProductDetail($slug){
        $product = Product::with(['product_images','category'=>function($q){
            $q->select('ProductCategory_SlNo','ProductCategory_Name');
        }])->where('slug',$slug)->firstOrFail();
        $r_products = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image')
            ->where('status', 'a')->inRandomOrder()->get();
        $r_products = $r_products->map(function ($el) {
            $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
            $current_stock = StockHelper::getProductStock($el->Product_SlNo);
            $el->size_wise_stock = $size_wise_stock;
            $el->current_stock = $current_stock;
            return $el;
        });
        $ll = StockHelper::getProductStock($product->Product_SlNo);
        $product->current_stock = $ll;
        $pp = StockHelper::getSizeWiseStock($product->Product_SlNo);
        $product->size_wise_stock = $pp;
        return view('front.pages.product-detail',compact('r_products','product'));
    }

    function checkoutPage(){
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return view('front.pages.checkout',compact('cart','count','subtotal'));
    }

    public function storeOrder(Request $request){
        $request->validate([
            'customer_name' => [
                'required',
                'string',
                'max:100',
            ],
            'customer_mobile' => [
                'required',
                'regex:/^01[3-9]\d{8}$/',
            ],
            'customer_address' => [
                'required',
                'string',
                'max:150',
            ],
            'order_notes' => [
                'nullable',
                'string',
                'max:200',
            ],
        ], [
            'customer_name.required' => 'আপনার নাম লিখুন।',
            'customer_name.string' => 'নাম অবশ্যই সঠিক হতে হবে।',
            'customer_name.max' => 'নাম সর্বোচ্চ ১০০ অক্ষরের হতে পারবে।',

            'customer_mobile.required' => 'আপনার মোবাইল নাম্বার লিখুন।',
            'customer_mobile.regex' => 'সঠিক বাংলাদেশি মোবাইল নাম্বার দিন।',

            'customer_address.required' => 'আপনার সম্পূর্ণ ঠিকানা লিখুন।',
            'customer_address.string' => 'ঠিকানা অবশ্যই সঠিক হতে হবে।',
            'customer_address.max' => 'ঠিকানা সর্বোচ্চ ১৫০ অক্ষরের হতে পারবে।',

            'order_notes.string' => 'Order notes অবশ্যই text হতে হবে।',
            'order_notes.max' => 'Order notes সর্বোচ্চ ২০০ অক্ষরের হতে পারবে।',
        ]);

        try{
            DB::beginTransaction();
            $cart = session('cart', []);
            $count = count($cart);
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
            if ($count < 1) {
                return redirect()->back()->with('error',"Your Cart Is Empty...😀");
            }

            $phone = $request->input('customer_mobile');
            $x_customer = Customer::where('Customer_Mobile', $phone)->first();
            if ($x_customer) {
                Auth::guard('customer')->login($x_customer);
            } else {
                $customer = new Customer();
                $code = 'C' . $this->generateCode('Customer');
                $customer->Customer_Name = $request->customer_name;
                $customer->Customer_Code = $code;
                $customer->Customer_Type = 'customer';
                $customer->Customer_Mobile = $request->customer_mobile;
                $customer->Customer_Phone = $request->customer_mobile;
                $customer->Customer_Address = $request->customer_address;
                $customer->password = Hash::make('12345678');
                $customer->last_update_ip = $request->ip();
                $customer->AddBy = 1;
                $customer->branch_id = '1';
                $customer->save();
                Auth::guard('customer')->login($customer);
            }
            $order = new Order();
            $order->SaleMaster_InvoiceNo = $order->generateSalesInvoice();
            $order->SalseCustomer_IDNo = Auth::guard('customer')->user()->Customer_SlNo;
            $order->customerType = Auth::guard('customer')->user()->Customer_Type;
            $order->customerName = $request->customer_name;
            $order->customerMobile = $request->customer_mobile;
            $order->customerName = $request->customer_name;
            $order->customerAddress = $request->customer_address;
            $order->SaleMaster_SaleDate = date("Y-m-d");
            $order->SaleMaster_SaleType = 'retail';
            $order->sales_from = 'web';
            $order->is_order = 'yes';
            $order->SaleMaster_SubTotalAmount = $subtotal;
            $order->SaleMaster_Freight = $request->shipment;
            $order->SaleMaster_TotalSaleAmount = $subtotal + $request->shipment;
            $order->SaleMaster_TotalDiscountAmount = 0;
            $order->SaleMaster_TaxAmount = 0;
            $order->SaleMaster_PaidAmount = 0;
            $order->cashPaid = 0;
            $order->bankPaid = 0;
            $order->SaleMaster_DueAmount = $subtotal + $request->shipment;
            $order->SaleMaster_Description = $request->order_notes;
            $order->status = 'p';
            $order->AddBy = 1;
            $order->AddTime = Carbon::now();
            $order->last_update_ip = $request->ip();
            $order->branch_id = 1;
            $order->save();
            foreach ($cart as $value) {
                $product = Product::where('Product_SlNo', $value['product_id'])->first();
                $orderDetails = new OrderDetails();
                $orderDetails->SaleMaster_IDNo = $order->SaleMaster_SlNo;
                $orderDetails->SaleMaster_IDNo = $order->SaleMaster_SlNo;
                $orderDetails->Product_IDNo = $value['product_id'];
                $orderDetails->Purchase_Rate = $product->Product_Purchase_Rate;
                $orderDetails->SaleDetails_Rate = $value['price'];
                $orderDetails->SaleDetails_TotalQuantity = $value['qty'];
                $orderDetails->size_id = $value['size'];
                $orderDetails->SaleDetails_Tax = 0;
                $price = (int)$value['qty'] * (float)$value['price'];
                $orderDetails->SaleDetails_TotalAmount = $price;
                $orderDetails->status = 'p';
                $orderDetails->is_service = 'false';
                $orderDetails->AddBy = 1;
                $orderDetails->AddTime = Carbon::now();
                $orderDetails->last_update_ip = $request->ip();
                $orderDetails->branch_id = 1;
                $orderDetails->save();
            }
            DB::commit();
            session()->forget('cart');
            return redirect()->route('dashboard')->with('success',"Order placed successfully!");
        }catch(Exception $e){
            DB::rollBack();
            return redirect()->route('home')->with($e->getMessage());

        }
    }



   public function getSearchProducts(Request $request){

        $products = collect();

        if ($request->filled('search')) {
            $products = Product::select(
                'Product_SlNo',
                'Product_Code',
                'Product_Name',
                'slug',
                'thum_image'
            )
                ->whereLike('Product_Name', "%". $request->search."%")
                ->whereNull('DeletedTime')
                ->limit(10)
                ->get();
        }
       


        return response()->json([
            'status' => true,
            'data' => $products
        ]);

   }



    

    



    






}

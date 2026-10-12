<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\StockHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Customerreview;
use App\Models\Fastiv;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Policy;
use App\Models\Product;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Subcategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //
    public function getProductsWithRaw($cluse = null, $orderBy = null, $limit = null)
    {
        // Prevent invalid SQL such as: IN ()
        if ($cluse && preg_match('/\bIN\s*\(\s*\)/i', $cluse)) {
            return [];
        }
        $sql = "
        SELECT
            p.Product_SlNo,
            p.Product_Code,
            p.Product_Name,
            p.have_size,
            p.slug,
            p.Product_SellingPrice,
            p.thum_image,
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN ROUND(
                    p.Product_SellingPrice -
                    (p.Product_SellingPrice * c.category_discount / 100),
                    2
                )
                ELSE p.Product_MinimumSellingPrice
            END AS Product_MinimumSellingPrice,
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN c.category_discount
                ELSE COALESCE(p.discount, 0)
            END AS discount
        FROM tbl_product AS p
        LEFT JOIN tbl_productcategory AS c
            ON p.ProductCategory_ID = c.ProductCategory_SlNo
        WHERE p.status = 'a'
          AND p.in_website = 1
    ";
        if (!empty($cluse)) {
            $sql .= " AND {$cluse}";
        }
        if (!empty($orderBy)) {
            $sql .= " ORDER BY {$orderBy}";
        }
        if (!empty($limit)) {
            $sql .= " LIMIT {$limit}";
        }
        return DB::select($sql);
    }

    public function index()
    {
        $sliders = Slider::where('status', 'a')->get();
        $banner = Banner::first();
        $categories = Category::select('ProductCategory_SlNo','slug', 'ProductCategory_Name', 'image')->where('status', 'a')->get();
        //new arrival
        $newArrivals = $this->getProductsWithRaw('p.new_arrival = 1', 'RAND()', 8);
        $newArrivals = array_map(function($ob){
            if($ob->have_size){
                $ob->size_wise_stock = StockHelper::getSizeWiseStock($ob->Product_SlNo);
            }else{
                $ob->size_wise_stock = null;
            }
            return $ob;
        },$newArrivals);
        //Popular Products
        $popular_roduct = $this->getProductsWithRaw('p.popular_product = 1', 'RAND()', 7);
        $popular_roduct = array_map(function ($ob) {
            if($ob->have_size){
                $ob->size_wise_stock = StockHelper::getSizeWiseStock($ob->Product_SlNo);
            }else{
                $ob->size_wise_stock = null;
            }
            return $ob;
        }, $popular_roduct);
        //product
        $products = $this->getProductsWithRaw('', 'RAND()', 8);
        $products = array_map(function ($ob) {
            $ob->size_wise_stock = $ob->have_size ?  StockHelper::getSizeWiseStock($ob->Product_SlNo) : null;
            return $ob;
        }, $products);
        $reviews = Review::select('id', 'image', 'title')->where('status', 'a')->inRandomOrder()->take(8)->get();
        $events = Fastiv::where('status', 'a')->get();
        $productIds = $events
            ->pluck('products')
            ->flatten()
            ->unique()
            ->values();
        $productIds = implode(',', $productIds->toArray());
        $event_products = collect(
            $this->getProductsWithRaw(
                "p.Product_SlNo IN ($productIds)"
            )
        )->keyBy('Product_SlNo');
        $events->each(function ($event) use ($event_products) {
            $event->attached_products = collect($event->products ?? [])
                ->map(function ($productId) use ($event_products) {
                     $eventProduct = $event_products->get($productId);
                     if($eventProduct->have_size){
                        $eventProduct->size_wise_stock = StockHelper::getSizeWiseStock($eventProduct->Product_SlNo);
                     }else{
                        $eventProduct->size_wise_stock = null;
                     }
                     return $eventProduct;
                })
                ->filter()
                ->values();
        });
        // return response()->json($events);
        $photoGallery = Gallery::where('type','p')->where('status','a')->inRandomOrder()->take(3)->get();
        $videoGallery = Gallery::where('type','v')->where('status','a')->inRandomOrder()->take(3)->get();
        $blogs = Blog::where('status','a')->orderBy('created_at','asc')->take(3)->get();
        return view('front.pages.home', compact('sliders', 'events', 'banner','videoGallery', 'categories', 'newArrivals', 'popular_roduct', 'products', 'reviews','photoGallery','blogs'));
    }

    public function allproducts()
    {
        $categories = Category::select('ProductCategory_SlNo', 'ProductCategory_Name', 'image')
            ->where('status', 'a')->get();
        $min = Product::min('Product_MinimumSellingPrice');
        $max = Product::max('Product_SellingPrice');
        return view('front.pages.shop', compact('categories', 'max', 'min'));
    }

    public function categoryWiseProducts($slug)
    {
        $category = Category::with([
            'subcategories' => function ($q) {
                $q->select('id', 'category_id', 'name', 'slug')->where('status', 'a');
            }
        ])->where('slug', $slug)->firstOrFail();
        $min = Product::min('Product_MinimumSellingPrice');
        $max = Product::max('Product_MinimumSellingPrice');
        return view('front.pages.category_wise', compact('category', 'max', 'min'));
    }

    public function subcategoryWiseProduct($slug){
        $subcategory = Subcategory::with([
            'childcategories' => function ($q) {
                $q->select('id', 'subcategory_id', 'name', 'slug','image')->where('status', 'a');
            },'category'=>function($q){
                $q->select('ProductCategory_SlNo','slug','banner','ProductCategory_Name');
            }
        ])->where('slug', $slug)->firstOrFail();
        // return response()->json($subcategories);
        $min = Product::min('Product_MinimumSellingPrice');
        $max = Product::max('Product_MinimumSellingPrice');
        return view('front.pages.sub_category_wise', compact('subcategory', 'max', 'min'));
    }

    public function childCategorywiseProduct($slug)
    {
        $childCategory = ChildCategory::with([
            'subcategory' => function ($q) {
                $q->select('id', 'category_id', 'name', 'slug', 'image')->where('status', 'a');
            },
            'subcategory.category' => function ($q) {
                $q->select('ProductCategory_SlNo', 'slug', 'banner', 'ProductCategory_Name');
            }
        ])->where('slug', $slug)->firstOrFail();
        $min = Product::min('Product_MinimumSellingPrice');
        $max = Product::max('Product_MinimumSellingPrice');
        return view('front.pages.child_category_wise', compact('childCategory', 'max', 'min'));
    }

    public function getSubCategoryId(Request $request){
        try{
            $data = $request->slug;
            $ob = Subcategory::where('slug', $data)->pluck('id')->firstOrFail();
            if($ob){
                return response()->json([
                    'status' => true,
                    'id' => $ob 
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'id' => null
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'status' => false,
                'id' => null
            ]);
        }
    }

    public function getCatWiseProducts(Request $request)
    {
        $products = DB::table('tbl_product as p')
            ->leftJoin(
                'tbl_productcategory as c',
                'p.ProductCategory_ID',
                '=',
                'c.ProductCategory_SlNo'
            )->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.have_size',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )->selectRaw("
                CASE
                    WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                    THEN ROUND(
                        p.Product_SellingPrice -
                        (p.Product_SellingPrice * c.category_discount / 100),
                        2
                    )
                    ELSE p.Product_MinimumSellingPrice
                END AS Product_MinimumSellingPrice
            ")->selectRaw("
                CASE
                    WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                    THEN c.category_discount
                    ELSE COALESCE(p.discount, 0)
                END AS discount
            ")->where(
                    'p.ProductCategory_ID',
                    $request->category_id
            )->when(
                !empty($request->sub_category),
                function ($query) use ($request) {
                    $query->whereIn(
                        'p.sub_categori_id',
                        $request->sub_category
                    );
                }
            )->when(
                !empty($request->child_category_id),
                function ($query) use ($request) {
                    $query->whereIn(
                        'p.child_category_id',
                        $request->child_category_id
                    );
                }
            )->when(
                $request->filled('min'),
                function ($query) use ($request) {
                    $query->whereRaw("
                    (
                        CASE
                            WHEN COALESCE(c.category_discount, 0)
                                > COALESCE(p.discount, 0)

                            THEN ROUND(
                                p.Product_SellingPrice -
                                (
                                    p.Product_SellingPrice
                                    * c.category_discount / 100
                                ),2
                            )
                            ELSE p.Product_MinimumSellingPrice
                        END
                    ) >= ?
                ", [$request->min]);
                }
            )->when(
                $request->filled('max'),
                function ($query) use ($request) {
                    $query->whereRaw("
                    (
                        CASE
                            WHEN COALESCE(c.category_discount, 0)
                                > COALESCE(p.discount, 0)
                            THEN ROUND(
                                p.Product_SellingPrice -
                                (
                                    p.Product_SellingPrice
                                    * c.category_discount / 100
                                ),2
                            )
                            ELSE p.Product_MinimumSellingPrice
                        END
                    ) <= ?
                ", [$request->max]);
                }
            )
            ->where('p.status', 'a')
            ->where('p.in_website', 1)
            ->inRandomOrder()
            ->paginate(18);

        $products->getCollection()->transform(function ($ob) {
            if ($ob->have_size) {
                $ob->size_wise_stock = StockHelper::getSizeWiseStock($ob->Product_SlNo);
            } else {
                $ob->size_wise_stock = null;
            }
            return $ob;
        });


        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    public function getSubCatWiseProducts(Request $request)
    {
        $products = DB::table('tbl_product as p')
            ->leftJoin(
                'tbl_productcategory as c',
                'p.ProductCategory_ID',
                '=',
                'c.ProductCategory_SlNo'
            )->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.have_size',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )->selectRaw("
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN ROUND(
                    p.Product_SellingPrice -
                    (p.Product_SellingPrice * c.category_discount / 100),2
                )
                ELSE p.Product_MinimumSellingPrice
            END AS Product_MinimumSellingPrice
        ")->selectRaw("
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN c.category_discount
                ELSE COALESCE(p.discount, 0)
            END AS discount
        ")->where(
                'p.sub_categori_id',
                $request->sub_categori_id
            )->when(
                !empty($request->child_category_id),
                function ($query) use ($request) {
                    $query->whereIn(
                        'p.child_category_id',
                        $request->child_category_id
                    );
                }
            )->when(
                $request->filled('min'),
                function ($query) use ($request) {
                    $query->whereRaw("
                    (
                        CASE
                            WHEN COALESCE(c.category_discount, 0)
                                > COALESCE(p.discount, 0)

                            THEN ROUND(
                                p.Product_SellingPrice -
                                (
                                    p.Product_SellingPrice
                                    * c.category_discount / 100
                                ),
                                2
                            )

                            ELSE p.Product_MinimumSellingPrice
                        END
                    ) >= ?
                ", [$request->min]);
                }
            )->when(
                $request->filled('max'),
                function ($query) use ($request) {
                    $query->whereRaw("
                    (
                        CASE
                            WHEN COALESCE(c.category_discount, 0)
                                > COALESCE(p.discount, 0)

                            THEN ROUND(
                                p.Product_SellingPrice -
                                (
                                    p.Product_SellingPrice
                                    * c.category_discount / 100
                                ),
                                2
                            )

                            ELSE p.Product_MinimumSellingPrice
                        END
                    ) <= ?
                ", [$request->max]);
                }
            )
            ->where('p.status', 'a')
            ->where('p.in_website', 1)
            ->inRandomOrder()
            ->paginate(18);

        $products->getCollection()->transform(function ($ob) {
            if ($ob->have_size) {
                $ob->size_wise_stock = StockHelper::getSizeWiseStock($ob->Product_SlNo);
            } else {
                $ob->size_wise_stock = null;
            }
            return $ob;
        });

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }




    public function getProducts(Request $request)
    {
        $products = DB::table('tbl_product as p')
            ->leftJoin(
                'tbl_productcategory as c',
                'p.ProductCategory_ID',
                '=',
                'c.ProductCategory_SlNo'
            )->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.have_size',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )->selectRaw("
                    CASE
                        WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                        THEN ROUND(
                            p.Product_SellingPrice -
                            (p.Product_SellingPrice * c.category_discount / 100),
                            2
                        )
                        ELSE p.Product_MinimumSellingPrice
                    END AS Product_MinimumSellingPrice
            ")->selectRaw("
                CASE
                    WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                    THEN c.category_discount
                    ELSE COALESCE(p.discount, 0)
                END AS discount
            ")->when(!empty($request->categories), function ($query) use ($request) {
                $query->whereIn(
                    'p.ProductCategory_ID',
                    $request->categories
                );
            })->when($request->child_category,function($query) use ($request){
                $query->where('child_category_id',$request->child_category);
            })->when($request->filled('min'), function ($query) use ($request) {
                $query->whereRaw("
                    (
                        CASE
                            WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                            THEN ROUND(
                                p.Product_SellingPrice -
                                (p.Product_SellingPrice * c.category_discount / 100),
                                2
                            )
                            ELSE p.Product_MinimumSellingPrice
                        END
                    ) >= ?
                ", [$request->min]);
            })->when($request->filled('max'), function ($query) use ($request) {
                $query->whereRaw("
            (
                CASE
                    WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                    THEN ROUND(
                        p.Product_SellingPrice -
                        (p.Product_SellingPrice * c.category_discount / 100),
                        2
                    )
                    ELSE p.Product_MinimumSellingPrice
                END
            ) <= ?
        ", [$request->max]);
            })
        ->when($request->product_type && $request->product_type == 'new_arrival', function($query) {
            $query->where('p.new_arrival',1);
        })
        ->when($request->product_type && $request->product_type == 'popular_product', function($query) {
            $query->where('p.popular_product',1);
        })
        ->where('p.status', 'a')
        ->where('p.in_website', 1)
        ->inRandomOrder()
        ->paginate(18);
        $products->getCollection()->transform(function ($ob) {
            if($ob->have_size){
                $ob->size_wise_stock = StockHelper::getSizeWiseStock($ob->Product_SlNo);
            }else{
                $ob->size_wise_stock = null;
            }
            return $ob;
        });
        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    public function getProductDetail($slug)
    {
        $returnPolicy = Policy::findOrFail(2);
        $deliveryPolicy = Policy::findOrFail(3);
        
        $product = Product::with([
            'product_images',
            'category' => function ($q) {
                $q->select('ProductCategory_SlNo', 'ProductCategory_Name','category_discount','slug');
            },
            'subcategory' => function ($q) {
                $q->select('id', 'name');
            },
            'p_brand' => function ($q) {
                $q->select('brand_SiNo', 'brand_name');
            },
            'color' => function($q){
                $q->select('Color_SlNo',"Color_Name");
            },

        ])->where('slug', $slug)->firstOrFail();

        $r_products = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image','have_size')
            ->where('status', 'a')->where('Product_SlNo',"!=" , $product->Product_SlNo)->where('in_website', 1)->where('ProductCategory_ID', $product->ProductCategory_ID)->inRandomOrder()->take(10)->get();
        

        // $ll = StockHelper::getProductStock($product->Product_SlNo);
        // $product->current_stock = $ll;

       if($product->have_size){
            $pp = StockHelper::getSizeWiseStock($product->Product_SlNo);
            $product->stocks = $pp;
        }else{
            $product->stocks = null;
        }
        // return response()->json($product);
        $total_reviews = Customerreview::where('Product_SlNo', $product->Product_SlNo)->where('status', 'a')->whereNull('deleted_at')->count();
        return view('front.pages.product-detail', compact('r_products', 'product', 'total_reviews', 'deliveryPolicy', 'returnPolicy'));
    }

    function checkoutPage()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        if(empty($cart)){
            return redirect()->route('all.products')->with('error',"Your Cart Is Empty!");
        }
        return view('front.pages.checkout', compact('cart', 'count', 'subtotal'));
    }

    public function storeOrder(Request $request)
    {
        $rules = [
            'customer_name' => ['required','string','max:100'],
            'customer_mobile' => ['required','regex:/^01[3-9]\d{8}$/'],
            'customer_address' => ['required','string','max:150',],
            'order_notes' => ['nullable','string','max:200'],
        ];
        if ($request->hasFile('payment_document') || $request->has('paid_amount')) {
            $rules['paid_amount'] = ['required','numeric','min:0'];
            $rules['payment_document'] = ['required','file','image','mimes:jpg,jpeg,png,webp','max:2048'];
        }
        if ($request->checkout_type == 'new_user') {
            $rules['password'] = ['required','string','min:8','max:50'];
        }
        $request->validate($rules, [
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

            'paid_amount.required' => 'পেমেন্টের পরিমাণ লিখুন।',
            'paid_amount.numeric' => 'পেমেন্টের পরিমাণ অবশ্যই সংখ্যা হতে হবে।',
            'paid_amount.min' => 'পেমেন্টের পরিমাণ ০-এর কম হতে পারবে না।',

            'payment_document.required' => 'পেমেন্টের screenshot দিন।',
            'payment_document.image' => 'পেমেন্টের document অবশ্যই একটি image হতে হবে।',
            'payment_document.mimes' => 'শুধু JPG, JPEG, PNG অথবা WebP image দেওয়া যাবে।',
            'payment_document.max' => 'পেমেন্টের image সর্বোচ্চ ২ MB হতে পারবে।',

            'password.required' => 'পাসওয়ার্ড লিখুন।',
            'password.string' => 'পাসওয়ার্ড অবশ্যই সঠিক হতে হবে।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.max' => 'পাসওয়ার্ড সর্বোচ্চ ৫০ অক্ষরের হতে পারবে।',
        ]);
        // try {
            DB::beginTransaction();
            $cart = session('cart', []);
            $count = count($cart);
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
            if ($count < 1) {
                return redirect()->back()->with('error', "Your Cart Is Empty...😀");
            }
            $alreadyPending = Order::where('customerMobile', $request->customer_mobile)->where('status','p')->first();
            if($alreadyPending){
                return redirect()->back()->with('error', "You Have Already a Panding Order...");
            }

            $min_rat = Company::value('minimum_rating');
            $frotCustomer = Order::where('customerMobile', $request->customer_mobile)->where('status', 'a')->orderBy('AddTime','desc')->first();
            $lastRatting = $frotCustomer->rating;
            $imagePath = null;
            if ($request->hasFile('payment_document')) {
                $imageFile = $request->file('payment_document');
                $imageName = $this->uploadImg($imageFile, 'uploads/advance_pay');
                $imagePath = 'uploads/advance_pay/' . $imageName;
            }
            $phone = $request->input('customer_mobile');
            $x_customer = Customer::where('Customer_Mobile', $phone)->first();
            $order = new Order();
            if($lastRatting < $min_rat){
                $order->SalseCustomer_IDNo = $frotCustomer->Customer_SlNo;
                $order->customerType = "customer";
                $order->customerMobile = $request->customer_mobile;
                $order->rating = $frotCustomer->rating;
            }else if ($x_customer) {
                Auth::guard('customer')->login($x_customer);
                $order->SalseCustomer_IDNo = Auth::guard('customer')->user()->Customer_SlNo;
                $order->customerType = Auth::guard('customer')->user()->Customer_Type;
                $order->customerMobile = $request->customer_mobile;
            } else if ($request->checkout_type == 'new_user') {
                $customer = new Customer();
                $code = 'C' . $this->generateCode('Customer');
                $customer->Customer_Name = $request->customer_name;
                $customer->Customer_Code = $code;
                $customer->Customer_Type = 'customer';
                $customer->Customer_Mobile = $request->customer_mobile;
                $customer->Customer_Phone = $request->customer_mobile;
                $customer->Customer_Address = $request->customer_address;
                $customer->password = Hash::make($request->password);
                $customer->last_update_ip = $request->ip();
                $customer->AddBy = 1;
                $customer->branch_id = '1';
                $customer->save();
                Auth::guard('customer')->login($customer);
                //add customer info in order table
                $order->SalseCustomer_IDNo = Auth::guard('customer')->user()->Customer_SlNo;
                $order->customerType = Auth::guard('customer')->user()->Customer_Type;
                $order->customerMobile = $request->customer_mobile;
            }else{
                $order->customerType = 'customer';
                $order->customerName = $request->customer_name;
                $order->customerMobile = $request->customer_mobile;
                $order->customerAddress = $request->customer_address;
            }
            $order->SaleMaster_InvoiceNo = $order->generateSalesInvoice();
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
            $order->cashPaid = $request->has('paid_amount') ? (int) $request->paid_amount : 0;
            $order->bankPaid = 0;
            $order->SaleMaster_DueAmount = $request->has('paid_amount')?    $subtotal + $request->shipment - (int) $request->paid_amount  : $subtotal + $request->shipment ;
            $order->SaleMaster_Description = $request->order_notes;
            $order->Advance_Payment_Document = $imagePath;
            $order->status = $lastRatting < $min_rat ? 'a' : 'p';
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
                $price = (int) $value['qty'] * (float) $value['price'];
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
            if($lastRatting < $min_rat){
                return redirect()->route('checkout_page')->with('notify',"You cannot proceed with your order. Please contact the admin via WhatsApp or phone to place your order.");
            }else if(Auth::guard('customer')->check()){
            session()->forget('cart');
                return redirect()->route('dashboard')->with('success', "Order placed successfully!");
            }else{
            session()->forget('cart');
                return redirect()->route('customer.order.invoice.guest',['id' => $order->SaleMaster_SlNo]);
            }
            

        // } catch (Exception $e) {
        //     DB::rollBack();
        //     return redirect()->route('home')->with('error' , $e->getMessage());
        // }
    }

    public function getSearchProducts(Request $request)
    {
        $products = collect();
        if ($request->filled('search')) {
            $products = Product::select('Product_SlNo','Product_Code','Product_Name','slug','thum_image')
            ->whereLike('Product_Name', "%" . $request->search . "%")
            ->orWhereLike('Product_Code', "%" . $request->search . "%")
            ->whereNull('DeletedTime')
            ->latest('AddTime')
            ->limit(5)
            ->get();
        }
        return response()->json([
            'status' => true,
            'data' => $products
        ]);
    }
    public function galleries(){
        $galleries = Gallery::where('status', 'a')->inRandomOrder()->get();
        return view('front.pages.galleries',compact('galleries'));
    }
    public function getAllBlogs(){
        $blogs = Blog::where('status', 'a')->orderBy('created_at', 'asc')->take(3)->get();
        return view('front.pages.blogs',compact('blogs'));

    }
    public function getBlog($slug){
        $blog = Blog::where('slug',$slug)->firstOrFail();
        $r_products = Product::select('Product_Name','slug','Product_SlNo','thum_image','ProductCategory_ID')->where('ProductCategory_ID',$blog->category_id)->inRandomOrder()->where('status','a')->take(12)->get();
        return view('front.pages.blog_detail',compact('blog','r_products'));
    }

    public function getTermsCondition(){
        $page = Policy::findOrFail(1);
        return view('front.pages.otherPages',compact('page'));
    }

    public function getPrivecyPolicy(){
        $page = Policy::findOrFail(5);
        return view('front.pages.otherPages', compact('page'));
    }
    public function getReturnPolicy(){
        $page = Policy::findOrFail(2);
        return view('front.pages.otherPages', compact('page'));
    }
    public function getDeliveryPolicy()
    {
        $page = Policy::findOrFail(3);
        return view('front.pages.otherPages', compact('page'));
    }
    
    public function freeShipping(){
        $page = Policy::findOrFail(6);
        return view('front.pages.otherPages', compact('page'));
    }
    public function authenticate(){
        $page = Policy::findOrFail(7);
        return view('front.pages.otherPages', compact('page'));
    }
    public function safeSecure(){
        $page = Policy::findOrFail(8);
        return view('front.pages.otherPages', compact('page'));
    }















}

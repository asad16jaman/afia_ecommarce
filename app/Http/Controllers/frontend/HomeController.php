<?php

namespace App\Http\Controllers\frontend;

use App\Helpers\StockHelper;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\ChildCategory;
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

        $newArrivals = $this->getProductsWithRaw('p.new_arrival = 1');
        $popular_roduct = $this->getProductsWithRaw('p.popular_product = 1');
        $products = $this->getProductsWithRaw('', 'RAND()', 20);
        $reviews = Review::select('id', 'image', 'title')->where('status', 'a')->get();
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
                    return $event_products->get($productId);
                })
                ->filter()
                ->values();
        });
        $galleries = Gallery::where('type','p')->where('status','a')->inRandomOrder()->take(6)->get();
        $blogs = Blog::where('status','a')->orderBy('created_at','asc')->take(3)->get();

        // return response()->json($galleries);
        return view('front.pages.home', compact('sliders', 'events', 'banner', 'categories', 'newArrivals', 'popular_roduct', 'products', 'reviews','galleries','blogs'));
    }

    // public function index()
    // {
    //     $sliders = Slider::where('status', 'a')->get();
    //     $banner = Banner::first();
    //     $categories = Category::select('ProductCategory_SlNo', 'ProductCategory_Name', 'image')->where('status', 'a')->get();
    //     $newArrivals = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image')
    //         ->where('new_arrival', 1)->where('status', 'a')->where('in_website', 1)->latest('AddTime')->take(28)->get();
    //     $newArrivals = $newArrivals->map(function ($el) {
    //         $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
    //         ;
    //         $current_stock = StockHelper::getProductStock($el->Product_SlNo);
    //         ;
    //         $el->size_wise_stock = $size_wise_stock;
    //         $el->current_stock = $current_stock;
    //         return $el;
    //     });
    //     $popular_roduct = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image')
    //         ->where('popular_product', 1)->where('status', 'a')->where('in_website', 1)->get();
    //     $popular_roduct = $popular_roduct->map(function ($el) {
    //         $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
    //         ;
    //         $current_stock = StockHelper::getProductStock($el->Product_SlNo);
    //         ;
    //         $el->size_wise_stock = $size_wise_stock;
    //         $el->current_stock = $current_stock;
    //         return $el;
    //     });
    //     $products = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image')
    //         ->where('status', 'a')->where('in_website', 1)->inRandomOrder()->take(20)->get();

    //     $products = $products->map(function ($el) {
    //         $size_wise_stock = StockHelper::getSizeWiseStock($el->Product_SlNo);
    //         $current_stock = StockHelper::getProductStock($el->Product_SlNo);
    //         $el->size_wise_stock = $size_wise_stock;
    //         $el->current_stock = $current_stock;
    //         return $el;
    //     });
    //     $reviews = Review::select('id', 'image', 'title')->where('status', 'a')->get();
    //     $events = Fastiv::where('status', 'a')->get();
    //     $productIds = $events
    //         ->pluck('products')
    //         ->flatten()
    //         ->unique()
    //         ->values();
    //     $products = Product::select(
    //         'Product_SlNo',
    //         'Product_Code',
    //         'Product_Name',
    //         'slug',
    //         'Product_SellingPrice',
    //         'Product_MinimumSellingPrice',
    //         'discount',
    //         'in_website',
    //         'thum_image',
    //         'ProductCategory_ID'
    //     )->with([
    //             'category' => function ($q) {
    //                 $q->select(
    //                     'ProductCategory_SlNo',
    //                     'ProductCategory_Name',
    //                     'category_discount'
    //                 );
    //             }
    //         ])
    //         ->whereIn('Product_SlNo', $productIds)
    //         ->where('in_website', 1)
    //         ->get()
    //         ->keyBy('Product_SlNo');

    //     $events->each(function ($event) use ($products) {
    //         $event->attached_products = collect($event->products ?? [])
    //             ->map(function ($productId) use ($products) {
    //                 return $products->get($productId);
    //             })
    //             ->filter()
    //             ->values();
    //     });

    //     return view('front.pages.home', compact('sliders','events', 'banner', 'categories', 'newArrivals', 'popular_roduct', 'products', 'reviews'));
    // }


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
        // $category = Category::with([
        //     'subcategories' => function ($q) {
        //         $q->select('id', 'category_id', 'name', 'slug')->where('status', 'a');
        //     },'subcategories.childcategories'=>function($q){
        //         $q->select('id','subcategory_id','name','slug')->where('status','a');
        //     }
        // ])->where('slug', $slug)->firstOrFail();
        
        $category = Category::with([
            'subcategories' => function ($q) {
                $q->select('id', 'category_id', 'name', 'slug')->where('status', 'a');
            }
        ])->where('slug', $slug)->firstOrFail();

        // return response()->json($category);
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
        // return response()->json($childCategory);
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
            )
            ->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )

            // Final minimum selling price
            ->selectRaw("
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN ROUND(
                    p.Product_SellingPrice -
                    (p.Product_SellingPrice * c.category_discount / 100),
                    2
                )
                ELSE p.Product_MinimumSellingPrice
            END AS Product_MinimumSellingPrice
        ")

            // Final discount
            ->selectRaw("
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
            )
            ->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )

            // Final minimum selling price
            ->selectRaw("
            CASE
                WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                THEN ROUND(
                    p.Product_SellingPrice -
                    (p.Product_SellingPrice * c.category_discount / 100),
                    2
                )
                ELSE p.Product_MinimumSellingPrice
            END AS Product_MinimumSellingPrice
        ")

            // Final discount
            ->selectRaw("
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
            )
            ->select(
                'p.Product_SlNo',
                'p.Product_Code',
                'p.Product_Name',
                'p.slug',
                'p.Product_SellingPrice',
                'p.thum_image'
            )
            ->selectRaw("
                    CASE
                        WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                        THEN ROUND(
                            p.Product_SellingPrice -
                            (p.Product_SellingPrice * c.category_discount / 100),
                            2
                        )
                        ELSE p.Product_MinimumSellingPrice
                    END AS Product_MinimumSellingPrice
                ")
            ->selectRaw("
                CASE
                    WHEN COALESCE(c.category_discount, 0) > COALESCE(p.discount, 0)
                    THEN c.category_discount
                    ELSE COALESCE(p.discount, 0)
                END AS discount
            ")
            ->when(!empty($request->categories), function ($query) use ($request) {
                $query->whereIn(
                    'p.ProductCategory_ID',
                    $request->categories
                );
            })
            ->when($request->child_category,function($query) use ($request){
                $query->where('child_category_id',$request->child_category);
            })
            ->when($request->filled('min'), function ($query) use ($request) {
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
            })
            ->when($request->filled('max'), function ($query) use ($request) {
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
            ->where('p.status', 'a')
            ->where('p.in_website', 1)
            ->inRandomOrder()
            ->paginate(18);

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    public function getProductDetail($slug)
    {
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
            }
        ])->where('slug', $slug)->firstOrFail();

        $r_products = Product::select('Product_SlNo', 'Product_Code', 'Product_Name', 'slug', 'Product_SellingPrice', 'Product_MinimumSellingPrice', 'discount', 'thum_image','have_size')
            ->where('status', 'a')->where('Product_SlNo',"!=" , $product->Product_SlNo)->where('in_website', 1)->where('ProductCategory_ID', $product->ProductCategory_ID)->inRandomOrder()->get();
        
        $ll = StockHelper::getProductStock($product->Product_SlNo);

        $product->current_stock = $ll;

        $pp = StockHelper::getSizeWiseStock($product->Product_SlNo);

        $product->size_wise_stock = $pp;

        $total_reviews = Customerreview::where('Product_SlNo', $product->Product_SlNo)->where('status', 'a')->whereNull('deleted_at')->count();
        $returnPolicy = Policy::findOrFail(2);
        $deliveryPolicy = Policy::findOrFail(3);
        // return response()->json($product);
        return view('front.pages.product-detail', compact('r_products', 'product', 'total_reviews', 'deliveryPolicy', 'returnPolicy'));
    }

    function checkoutPage()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return view('front.pages.checkout', compact('cart', 'count', 'subtotal'));
    }

    public function storeOrder(Request $request)
    {
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

        try {
            DB::beginTransaction();
            $cart = session('cart', []);
            $count = count($cart);
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
            if ($count < 1) {
                return redirect()->back()->with('error', "Your Cart Is Empty...😀");
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
            session()->forget('cart');
            return redirect()->route('dashboard')->with('success', "Order placed successfully!");
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('home')->with($e->getMessage());

        }
    }

    public function getSearchProducts(Request $request)
    {
        $products = collect();
        if ($request->filled('search')) {
            $products = Product::select(
                'Product_SlNo',
                'Product_Code',
                'Product_Name',
                'slug',
                'thum_image'
            )
                ->whereLike('Product_Name', "%" . $request->search . "%")
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

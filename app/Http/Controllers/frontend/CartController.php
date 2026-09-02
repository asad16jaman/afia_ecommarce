<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Log;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->product_id;

        $cartProduct = Product::with(['category'=>function($q){
            $q->select('ProductCategory_SlNo','category_discount');
        }])
        ->select('Product_SlNo','ProductCategory_ID','Product_SellingPrice','Product_MinimumSellingPrice','discount')
        ->where('Product_SlNo', $productId)->first();

        if(!$cartProduct){
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found'
            ]);
        }

        $productPrice = $cartProduct->Product_MinimumSellingPrice;
        if((float)$cartProduct->category->category_discount > (float)$cartProduct->discount){
            $productPrice = $cartProduct->Product_SellingPrice - (($cartProduct->Product_SellingPrice * $cartProduct->category->category_discount) / 100);
        }

        $size = $request->size;
        $price = $productPrice;
        $qty = $request->qty;
        $cart = Session::get('cart', []);

        if($size){
            $key = $productId . "_" . $size;
        }else{
            $key = $productId;
        }
        

        $totalPrice = (float)$price * (float) $qty; 
        

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'size' => $size ?? null,
                'size_name' => $request->size_name ?? null,
                'price' => $price,
                'qty' => $qty,
                'name' => $request->name,
                'image' => $request->img ? config('app.soft_url'). $request->img : asset('uploads/no_images/no-image.png'),
                'total_price' => $totalPrice,
            ];
        }

        Session::put('cart', $cart);

    //    session()->forget('cart');
    //     $cart = Session::get('cart', []);

        $count = count($cart);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return response()->json([
            'success' => true,
            'count' => $count,
            'subtotal' => $subtotal,
            'cart' => $cart
        ]);
    }

    public function get_cart_data(){
        $cart = Session::get('cart', []);
        $count = count($cart);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return response()->json([
            'success' => true,
            'count' => $count,
            'subtotal' => $subtotal,
            'cart' => $cart
        ]);

    }

    public function buyNow($request){


        $productId = $request->product_id;
        $size = $request->size;

        $buyProduct = Product::where('Product_SlNo',$productId)->firstOrFail();

        
        $price = $buyProduct->Product_MinimumSellingPrice;
        $qty = 1;

        $cart = Session::get('cart', []);
        $key = $productId . "-" . $size;;
        $totalPrice = (float)$price * (float) $qty; 
        

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'price' => $price,
                 'size' => $size,
                'qty' => $qty,
                'name' => $buyProduct->Product_Name,
                'image' => $buyProduct->thum_image ?? 'uploads/no_images/no-image.png',
                'total_price' => $totalPrice,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('order.checkout');

    }


    public function update(Request $request)
    {
        $cart = session('cart', []);
        $key = $request->key;
        $qty = max(1, (int) $request->qty);
        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        $count = count($cart);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        return response()->json([
            'success' => true,
            'count' => $count,
            'subtotal' => $subtotal,
            'cart' => $cart,
            'item' => $cart[$key]
        ]);
    }

    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return response()->json([
            'count' => $count,
            'subtotal' => $subtotal
        ]);
    }

    public function data()
    {
        $cart = Session::get('cart', []);
        return view('frontend.partials.cart_data', compact('cart'))->render();
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->key]);
        session()->put('cart', $cart);

        $count = count($cart);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        return response()->json([
            'success' => true,
            'count' => $count,
            'subtotal' => $subtotal,
            'cart' => $cart
           
        ]);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'count' => 0,
            'subtotal' => 0,
            'cart' => []
        ]);
    }

    // public function addWish(int $id){
    //     $product = Product::find($id);
    //     if($product){
    //         $already = Wishlist::where('product_id',$product->id)->first();
    //         if(!$already){
    //             Wishlist::create([
    //                 "customer_id" => Auth::guard('customer')->user()->id,
    //                 'product_id' =>  $product->id
    //             ]);
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Successfully Added To Wishlist!'
    //             ]);
    //         }else{
    //            return response()->json([
    //                 'success' => true,
    //                 'message' => 'This Product Already In Your Wishlist!'
    //             ]); 
    //         }
            
    //     }else{
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Product Not Found!'
    //         ]);
    //     }
    // }
}

<?php

namespace App\Http\Controllers\frontend;

use App\Models\Product;
use App\Models\Wishlist;
use Exception;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $price = $request->price;
        $qty = $request->qty;
        $cart = Session::get('cart', []);
        $key = $productId;
        $totalPrice = (float)$price * (float) $qty; 
        

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'p_slug' => $request->p_slug,
                'price' => $price,
                'qty' => $qty,
                'name' => $request->name,
                'image' => $request->img ?? 'uploads/no_images/no-image.png',
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

    public function buyNow(string $slug){

        
        $buyProduct = Product::where('slug',$slug)->first();
        $productId = $buyProduct->id;
        $price = $buyProduct->price;
        $qty = 1;
        $cart = Session::get('cart', []);
        $key = $productId;
        $totalPrice = (float)$price * (float) $qty; 
        

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'p_slug' => $buyProduct->slug,
                'price' => $price,
                'qty' => $qty,
                'name' => $buyProduct->name,
                'image' => $buyProduct->thumbnail_image ?? 'uploads/no_images/no-image.png',
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

    public function addWish(int $id){
        $product = Product::find($id);
        if($product){
            $already = Wishlist::where('product_id',$product->id)->first();
            if(!$already){
                Wishlist::create([
                    "customer_id" => Auth::guard('customer')->user()->id,
                    'product_id' =>  $product->id
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully Added To Wishlist!'
                ]);
            }else{
               return response()->json([
                    'success' => true,
                    'message' => 'This Product Already In Your Wishlist!'
                ]); 
            }
            
        }else{
            return response()->json([
                'success' => true,
                'message' => 'Product Not Found!'
            ]);
        }
    }
}

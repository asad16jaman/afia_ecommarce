<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    //

    public function index()
    {
       return view('front.pages.home');
    }


    public function getProductDetail($slug){
        return view('front.pages.product-detail');
    }

    



    

    



    






}

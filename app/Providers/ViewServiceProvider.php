<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //

        View::composer('*', function ($view) {

                $defaultSettings = [
                'Company_Logo_thum' => '',
                'Company_Logo_org' => '',
                'Currency_Name' => '৳',
                'Currency_Symbol' => '৳',
                'company_fav' => '',
                'facebook_link' => '',
                'whatsapp' => '',
                'address' => '1234 Sample Address',
                'phone' => '123-456-7890',
                'hotline_number' => '123-000-0000',
                'email' => 'info@samplecompany.com',
                'Company_Name' => 'Sample Company',
                'instagrame_link' => '',
                'youtube' => '',
                // 'footer_short_description' => 'We’re committed to delivering excellence.',
                // 'google_map' => '<iframe src="..."></iframe>',
            ];
            $setting = Company::first();
            $nav_category = Category::with(['subcategories'=>function($q){
                $q->select('id','category_id','name','slug');
            }])->select('ProductCategory_Name', 'ProductCategory_SlNo')->where('status' , 'a')->take(6)->get();
            if (!$setting) {
                $setting = (object) $defaultSettings;
            }
            
            $view->with('setting',$setting);
            $view->with('currency', $setting->Currency_Symbol);
            $view->with('nav_categories' , $nav_category);

            
            });

        View::share('softUrl', config('app.soft_url'));
        // View::share('softUrl', request()->getScheme() . '://soft.afialifestyle.com/');


    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        
    }
}

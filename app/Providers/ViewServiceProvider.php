<?php

namespace App\Providers;

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
                'name' => 'Sample Company',
                'address' => '1234 Sample Address',
                'phone' => '123-456-7890',
                'hotline' => '123-000-0000',
                'slogan' => 'We make things better',
                'email' => 'info@samplecompany.com',

                'facebook_url' => '',
                'twitter_url' => '',
                'linkedin_url' => '',
                'youtube_url' => '',
                'website_url' => '',
                'favicon_image' => '',
                'logo' => '',
                'footer_title' => 'Quick Links',
                'footer_short_description' => 'We’re committed to delivering excellence.',
                'google_map' => '<iframe src="..."></iframe>',
            ];
            $setting = Company::first();
            if (!$setting) {
                $setting = (object) $defaultSettings;
            }
            $view->with('setting',$setting);
               

                

                
                
            });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

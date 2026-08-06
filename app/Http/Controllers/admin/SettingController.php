<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function setting()
    {
        try {
            $setting = Company::firstOrNew([], [
                'name' => 'Sample Company',
                'address' => '1234 Sample Address',
                'phone' => '123-456-7890',
                'email' => 'info@samplecompany.com',
                'facebook_url' => '',
                'twitter_url' => '',
                'linkedin_url' => '',
                'youtube_url' => '',
                'favicon_image' => '',
                'website_url' => '',
                'logo' => '',
                'footer_title' => '',
                'footer_short_description' => '',
                'google_map' => '',
            ]);

            return view('admin.settings.general_setting', compact('setting'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving or processing the settings: ' . $e->getMessage());
            return redirect()
                ->route('dashboard')
                ->with('error', 'An unexpected error occurred while loading the settings. Please try again later.');
        }
    }


    public function update(Request $request)
    {

        // return response()->json('astace....');
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'favicon_image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            // 'footer_title' => 'nullable|string|max:255',
            'footer_short_description' => 'nullable|string|max:1000',
            'google_map' => 'nullable|string',
            'heritage' => 'nullable',
            'production_capacity' => 'nullable',
            'total_workforce' => 'nullable',
            'total_projects' => 'nullable',
            'website_url' => 'nullable|string',
            'sales_title' => 'nullable|string|max:254',
            'sales_address' => 'nullable|string|max:254',
            'cons_address' => 'nullable|string|max:254',
            'cons_title' => 'nullable|string|max:254',
            'design_title' => 'nullable|string|max:254',
            'design_address' => 'nullable|string|max:254',
            'manag_address' => 'nullable|string|max:254',
            'manag_title' => 'nullable|string|max:254',
        ]);

        try {
            $setting = Company::first();
            if (!$setting) {
                $setting = new Company();
            }

            // Handle favicon image upload
            if ($request->hasFile('favicon_image')) {
                if ($setting->favicon_image && file_exists(public_path('uploads/logo_and_icon/' . $setting->favicon_image))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->favicon_image));
                }
                $faviconImage = $request->file('favicon_image');
                $faviconName = now()->format('Ymd') . rand(1000, 9999) . '.' . $faviconImage->getClientOriginalExtension();
                $faviconImage->move(public_path('uploads/logo_and_icon'), $faviconName);
                $setting->favicon_image = $faviconName;
            }

             if ($request->hasFile('file_thum')) {
                if ($setting->file_thum && file_exists(public_path('uploads/logo_and_icon/' . $setting->file_thum))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->file_thum));
                }
                $imageFile = $request->file('file_thum');
                $imageName =  $this->resizeAndUpload($imageFile,'uploads/logo_and_icon',500,400,200);
                $setting->file_thum = $imageName;
            }

            // Handle company logo upload
            if ($request->hasFile('logo')) {
                if ($setting->logo && file_exists(public_path('uploads/logo_and_icon/' . $setting->logo))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->logo));
                }
                $logoImage = $request->file('logo');
                $logoName = now()->format('Ymd') . rand(1000, 9999) . '.' . $logoImage->getClientOriginalExtension();
                $logoImage->move(public_path('uploads/logo_and_icon'), $logoName);
                $setting->logo = $logoName;
            }

            // Handle company logo upload
            if ($request->hasFile('file')) {
                if ($setting->file && file_exists(public_path('uploads/logo_and_icon/' . $setting->file))) {
                    unlink(public_path('uploads/logo_and_icon/' . $setting->file));
                }
                $logoImage = $request->file('file');
                $logoName = now()->format('Ymd') . rand(1000, 9999) . '.' . $logoImage->getClientOriginalExtension();
                $logoImage->move(public_path('uploads/logo_and_icon'), $logoName);
                $setting->file = $logoName;
            }

            // Update other fields
            $setting->name = $request->name;
            $setting->address = $request->address;
            $setting->phone = $request->phone;
            $setting->email = $request->email;
            $setting->facebook_url = $request->facebook_url;
            $setting->twitter_url = $request->twitter_url;
            $setting->linkedin_url = $request->linkedin_url;
            $setting->youtube_url = $request->youtube_url;
            $setting->footer_short_description = $request->footer_short_description;

            $setting->website_url = $request->website_url;
            $setting->heritage = $request->heritage;
            $setting->production_capacity = $request->production_capacity;
            $setting->total_workforce = $request->total_workforce;
            $setting->total_projects = $request->total_projects;
            $setting->video = $request->video;
            $setting->file_title = $request->file_title;
            $setting->google_map = $request->google_map;

          

            $setting->ip_address = $request->ip();
            $setting->updated_by = Auth::user()->id;

            $setting->save();

            return redirect()->back()->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating settings: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings. Please try again later.');
        }
    }
}

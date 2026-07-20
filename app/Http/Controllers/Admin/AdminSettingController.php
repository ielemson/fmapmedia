<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminSettingController extends Controller
{
    /**
     * Display the general settings form.
     */
    public function edit(): View
    {
        $setting = Setting::firstOrCreate(
            [],
            [
                'site_name' => 'FMAP Media',
                'currency_code' => 'NGN',
                'currency_symbol' => '₦',
                'maintenance_mode' => false,
            ]
        );

        return view('admin.settings.general', compact('setting'));
    }

    /**
     * Update the general settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Branding
            |--------------------------------------------------------------------------
            */

            'site_name' => [
                'required',
                'string',
                'max:150',
            ],

            'site_tagline' => [
                'nullable',
                'string',
                'max:255',
            ],

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'footer_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'favicon' => [
                'nullable',
                'file',
                'mimes:ico,png,jpg,jpeg,webp',
                'max:1024',
            ],

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'support_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Social Media
            |--------------------------------------------------------------------------
            */

            'facebook_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'instagram_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'twitter_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'linkedin_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'youtube_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | Platform
            |--------------------------------------------------------------------------
            */

            'currency_code' => [
                'required',
                'string',
                'max:10',
            ],

            'currency_symbol' => [
                'required',
                'string',
                'max:10',
            ],

            'maintenance_message' => [
                'nullable',
                'string',
                'max:2000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Footer
            |--------------------------------------------------------------------------
            */

            'footer_about' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'copyright_text' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $setting = Setting::firstOrCreate([]);

        $validated['maintenance_mode'] = $request->boolean(
            'maintenance_mode'
        );

        $validated['logo'] = $this->handleUpload(
            request: $request,
            field: 'logo',
            oldFile: $setting->logo
        );

        $validated['footer_logo'] = $this->handleUpload(
            request: $request,
            field: 'footer_logo',
            oldFile: $setting->footer_logo
        );

        $validated['favicon'] = $this->handleUpload(
            request: $request,
            field: 'favicon',
            oldFile: $setting->favicon
        );

        $setting->update($validated);

        Cache::forget('general_settings');

        return back()->with(
            'success',
            'General settings updated successfully.'
        );
    }

    /**
     * Upload a settings file and delete the previous file.
     */
    private function handleUpload(
        Request $request,
        string $field,
        ?string $oldFile = null
    ): ?string {
        if (! $request->hasFile($field)) {
            return $oldFile;
        }

        if (
            $oldFile &&
            Storage::disk('public')->exists($oldFile)
        ) {
            Storage::disk('public')->delete($oldFile);
        }

        return $request
            ->file($field)
            ->store('settings', 'public');
    }
}
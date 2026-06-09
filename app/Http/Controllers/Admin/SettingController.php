<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.settings', compact('settings'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'           => 'required|string|max:255',
            'site_email'          => 'nullable|email|max:255',
            'site_description'    => 'nullable|string|max:1000',
            'site_keywords'       => 'nullable|string|max:500',
            'site_phone'          => 'nullable|string|max:50',
            'site_address'        => 'nullable|string|max:500',
            'facebook_url'        => 'nullable|url|max:500',
            'twitter_url'         => 'nullable|url|max:500',
            'instagram_url'       => 'nullable|url|max:500',
            'whatsapp_number'     => 'nullable|string|max:50',
            'default_currency'    => 'nullable|string|max:10',
            'site_status'         => 'nullable|in:active,maintenance,closed',
            'maintenance_message' => 'nullable|string|max:1000',
            'site_logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon'        => 'nullable|image|mimes:png,ico|max:1024',
        ]);

        // Handle file uploads
        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::where('key', 'site_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('site_logo')->store('settings', 'public');
            $validated['site_logo'] = $logoPath;
        }

        if ($request->hasFile('site_favicon')) {
            // Delete old favicon if exists
            $oldFavicon = Setting::where('key', 'site_favicon')->value('value');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            $validated['site_favicon'] = $faviconPath;
        }

        // Save each setting
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return redirect()->route('admin.settings.index')
                         ->with('success', 'تم حفظ الإعدادات بنجاح!');
    }
}

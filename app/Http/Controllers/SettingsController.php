<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function company()
    {
        return Inertia::render('Settings/Company', [
            'settings' => CompanySetting::all()->groupBy('group'),
        ]);
    }

    public function updateCompany(Request $request)
    {
        $settings = $request->input('settings');

        foreach ($settings as $key => $value) {
            CompanySetting::where('key', $key)->update(['value' => $value]);
            Cache::forget("company_setting_{$key}");
        }

        return redirect()->back()->with('success', 'Pengaturan perusahaan berhasil diperbarui.');
    }
}

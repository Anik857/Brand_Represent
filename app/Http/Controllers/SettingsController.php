<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingsController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the settings index page.
     */
    public function index()
    {
        $groups = Setting::select('group')->distinct()->pluck('group');
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        
        return view('settings.index', compact('groups', 'settings'));
    }

    /**
     * Show the form for editing settings.
     */
    public function edit($group = 'general')
    {
        $settings = Setting::byGroup($group)->get();
        $availableGroups = Setting::select('group')->distinct()->pluck('group');
        
        return view('settings.edit', compact('settings', 'group', 'availableGroups'));
    }

    /**
     * Update the specified settings.
     */
    public function update(Request $request, $group = 'general')
    {
        $request->validate([
            'settings' => 'array',
        ]);

        foreach ($request->settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->setValue($value);
                $setting->save();
            }
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    /**
     * Store a newly created setting.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:settings,key',
            'value' => 'nullable',
            'type' => 'required|in:string,boolean,integer,json',
            'group' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        Setting::create($request->all());

        return redirect()->route('settings.index')
            ->with('success', 'Setting created successfully.');
    }

    /**
     * Remove the specified setting.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index')
            ->with('success', 'Setting deleted successfully.');
    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        $availableGroups = Setting::select('group')->distinct()->pluck('group');
        return view('settings.create', compact('availableGroups'));
    }

    /**
     * Display the specified setting.
     */
    public function show(Setting $setting)
    {
        return view('settings.show', compact('setting'));
    }
}
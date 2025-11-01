<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();
        return view('banners.index', compact('banners'));
    }

    public function create()
    {
        return view('banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|string|max:100|unique:banners,key',
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'link_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $stored = $file->storeAs('banners', $filename, 'public');
            if ($stored) {
                $imagePath = $stored; // store relative path under public disk
            }
        }

        Banner::create([
            'key' => $data['key'],
            'title' => $data['title'] ?? null,
            'image_path' => $imagePath,
            'link_url' => $data['link_url'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'link_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $update = [
            'title' => $data['title'] ?? null,
            'link_url' => $data['link_url'] ?? null,
            'is_active' => $request->boolean('is_active', $banner->is_active),
            'sort_order' => $data['sort_order'] ?? $banner->sort_order,
        ];

        if ($request->hasFile('image')) {
            // delete old if local
            if ($banner->image_path && str_starts_with($banner->image_path, 'banners/')) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $stored = $file->storeAs('banners', $filename, 'public');
            if ($stored) {
                $update['image_path'] = $stored;
            }
        }

        $banner->update($update);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path && str_starts_with($banner->image_path, 'banners/')) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}

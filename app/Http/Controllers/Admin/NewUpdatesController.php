<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewUpdatesController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search by title or author
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Filter by published status
        if ($request->filled('status')) {
            $query->where('is_published', (bool) ((int) $request->get('status')));
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->where('author', $request->get('author'));
        }

        // Sorting
        switch ($request->get('sort')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'views':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $blogs = $query->paginate(10)->withQueryString();

        return view('admin.new-updates.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.new-updates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/blogs', $imageName);
            $data['featured_image'] = 'blogs/' . $imageName;
        }

        Blog::create($data);

        return redirect()->route('admin.new-updates.index')
            ->with('success', 'New update created successfully.');
    }

    public function show(Blog $newUpdate)
    {
        return view('admin.new-updates.show', compact('newUpdate'));
    }

    public function edit(Blog $newUpdate)
    {
        return view('admin.new-updates.edit', compact('newUpdate'));
    }

    public function update(Request $request, Blog $newUpdate)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'author' => 'required|string|max:255',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        
        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($newUpdate->featured_image && Storage::disk('public')->exists($newUpdate->featured_image)) {
                Storage::disk('public')->delete($newUpdate->featured_image);
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/blogs', $imageName);
            $data['featured_image'] = 'blogs/' . $imageName;
        }

        $newUpdate->update($data);

        return redirect()->route('admin.new-updates.index')
            ->with('success', 'New update updated successfully.');
    }

    public function destroy(Blog $newUpdate)
    {
        // Delete image file
        if ($newUpdate->featured_image && Storage::disk('public')->exists($newUpdate->featured_image)) {
            Storage::disk('public')->delete($newUpdate->featured_image);
        }
        
        $newUpdate->delete();

        return redirect()->route('admin.new-updates.index')
            ->with('success', 'New update deleted successfully.');
    }
}
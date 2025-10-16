<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->latest()
            ->paginate(9);

        return view('blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        $blog->incrementViews();
        
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->limit(3)
            ->get();

        return view('blogs.show', compact('blog', 'relatedBlogs'));
    }

    public function getLatestForHomepage()
    {
        return Blog::published()
            ->latest()
            ->limit(3)
            ->get();
    }
}
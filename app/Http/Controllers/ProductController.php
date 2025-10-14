<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        $products = $query->with('category')->paginate(12);

        // Get categories for filter dropdown
        $categories = \App\Models\Category::active()->ordered()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::active()->ordered()->get();
        
        $brands = [
            'Apple',
            'Samsung',
            'Nike',
            'Adidas',
            'Sony',
            'Microsoft',
            'Google',
            'Amazon',
            'Tesla',
            'BMW'
        ];

        return view('products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle image uploads
        $data['images'] = $this->handleImageUploads($request);

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::active()->ordered()->get();

        $brands = [
            'Apple',
            'Samsung',
            'Nike',
            'Adidas',
            'Sony',
            'Microsoft',
            'Google',
            'Amazon',
            'Tesla',
            'BMW'
        ];

        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string',
            'status' => 'required|in:active,inactive,draft',
            'featured' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle removed images
        $currentImages = $product->images ?? [];
        if ($request->has('removed_images')) {
            $removedImages = $request->removed_images;
            $this->deleteImages($removedImages);
            $currentImages = array_diff($currentImages, $removedImages);
        }

        // Handle new image uploads
        $uploadedImages = $this->handleImageUploads($request);
        if (!empty($uploadedImages)) {
            // Merge current images with new uploads
            $data['images'] = array_merge($currentImages, $uploadedImages);
        } else {
            // Keep existing images if no new ones provided
            $data['images'] = $currentImages;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete associated images
        $this->deleteImages($product->images);

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['featured' => !$product->featured]);

        return response()->json([
            'success' => true,
            'featured' => $product->featured
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $productIds = $request->product_ids;

        if (!$productIds || !$action) {
            return redirect()->back()->with('error', 'Please select products and an action.');
        }

        switch ($action) {
            case 'delete':
                Product::whereIn('id', $productIds)->delete();
                $message = 'Selected products deleted successfully.';
                break;
            case 'activate':
                Product::whereIn('id', $productIds)->update(['status' => 'active']);
                $message = 'Selected products activated successfully.';
                break;
            case 'deactivate':
                Product::whereIn('id', $productIds)->update(['status' => 'inactive']);
                $message = 'Selected products deactivated successfully.';
                break;
            case 'feature':
                Product::whereIn('id', $productIds)->update(['featured' => true]);
                $message = 'Selected products marked as featured.';
                break;
            case 'unfeature':
                Product::whereIn('id', $productIds)->update(['featured' => false]);
                $message = 'Selected products unmarked as featured.';
                break;
            default:
                return redirect()->back()->with('error', 'Invalid action selected.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Handle image uploads
     */
    private function handleImageUploads(Request $request)
    {
        $uploadedImages = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            // Ensure images is an array
            if (!is_array($images)) {
                $images = [$images];
            }

            foreach ($images as $image) {
                if ($image->isValid()) {
                    // Validate image
                    $validator = Validator::make(['image' => $image], [
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                    ]);

                    if ($validator->fails()) {
                        continue; // Skip invalid images
                    }

                    // Generate unique filename
                    $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    // Store image in public/products directory
                    $path = $image->storeAs('products', $filename, 'public');

                    if ($path) {
                        $uploadedImages[] = Storage::url($path);
                    }
                }
            }
        }

        // If no images uploaded, use placeholder
        if (empty($uploadedImages)) {
            $uploadedImages = [
                'https://via.placeholder.com/300x300/4f46e5/ffffff?text=No+Image'
            ];
        }

        return $uploadedImages;
    }

    /**
     * Delete images from storage
     */
    private function deleteImages($images)
    {
        if (!$images) {
            return;
        }

        foreach ($images as $image) {
            // Only delete local images, not placeholder URLs
            if (str_contains($image, '/storage/products/')) {
                $path = str_replace('/storage/', '', $image);
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Upload single image via AJAX
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');

            if ($path) {
                return response()->json([
                    'success' => true,
                    'url' => Storage::url($path),
                    'filename' => $filename
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to upload image'
        ], 400);
    }

    /**
     * Delete single image via AJAX
     */
    public function deleteImage(Request $request)
    {
        $imageUrl = $request->input('image_url');

        if ($imageUrl && str_contains($imageUrl, '/storage/products/')) {
            $path = str_replace('/storage/', '', $imageUrl);
            Storage::disk('public')->delete($path);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid image URL'
        ], 400);
    }
}

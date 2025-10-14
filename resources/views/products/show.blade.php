@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">{{ $product->name }}</h4>
                    <p class="text-muted mb-0">Product Details</p>
                </div>
                <div>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-body">
                    @if($product->images && count($product->images) > 0)
                        <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $image }}" class="d-block w-100" alt="Product Image {{ $index + 1 }}" style="height: 300px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($product->images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        @if(count($product->images) > 1)
                            <div class="row mt-3">
                                @foreach($product->images as $index => $image)
                                    <div class="col-4">
                                        <img src="{{ $image }}" class="img-fluid rounded cursor-pointer" 
                                             alt="Thumbnail {{ $index + 1 }}" 
                                             onclick="changeSlide({{ $index }})"
                                             style="height: 60px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No images available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>SKU:</strong></td>
                                    <td>{{ $product->sku }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $product->category->name ?? 'No Category' }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Brand:</strong></td>
                                    <td>{{ $product->brand ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $product->status_badge }}">{{ ucfirst($product->status) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>
                                        <span class="h5 text-primary">{{ $product->formatted_price }}</span>
                                        @if($product->compare_price)
                                            <small class="text-muted text-decoration-line-through ms-2">{{ $product->formatted_compare_price }}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Quantity:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                            {{ $product->quantity }} in stock
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Featured:</strong></td>
                                    <td>
                                        @if($product->featured)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @else
                                            <span class="text-muted">No</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($product->discount_percentage > 0)
                                <tr>
                                    <td><strong>Discount:</strong></td>
                                    <td>
                                        <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    @if($product->description)
                        <div class="mt-3">
                            <h6>Description</h6>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Physical Properties -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Physical Properties</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Weight:</strong></td>
                                    <td>{{ $product->weight ? $product->weight . ' lbs' : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dimensions:</strong></td>
                                    <td>{{ $product->dimensions ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Created:</strong></td>
                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $product->updated_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($product->meta_title || $product->meta_description)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">SEO Information</h5>
                </div>
                <div class="card-body">
                    @if($product->meta_title)
                        <div class="mb-3">
                            <strong>Meta Title:</strong>
                            <p class="text-muted">{{ $product->meta_title }}</p>
                        </div>
                    @endif
                    @if($product->meta_description)
                        <div class="mb-3">
                            <strong>Meta Description:</strong>
                            <p class="text-muted">{{ $product->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Product
                        </a>
                        <button class="btn btn-outline-warning" onclick="toggleFeatured({{ $product->id }})">
                            <i class="fas fa-star me-2"></i>
                            {{ $product->featured ? 'Unmark as Featured' : 'Mark as Featured' }}
                        </button>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-2"></i>Delete Product
                            </button>
                        </form>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-2"></i>View All Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Carousel thumbnail navigation
    function changeSlide(index) {
        const carousel = document.getElementById('productImageCarousel');
        const carouselInstance = new bootstrap.Carousel(carousel);
        carouselInstance.to(index);
    }

    // Toggle featured status
    function toggleFeatured(productId) {
        fetch(`/products/${productId}/toggle-featured`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the product.');
        });
    }
</script>
@endsection

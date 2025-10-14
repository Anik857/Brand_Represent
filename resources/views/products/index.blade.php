@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Products</h4>
                    <p class="text-muted mb-0">Manage your product inventory</p>
                </div>
                <div>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Search products...">
                        </div>
                        <div class="col-md-2">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="featured" class="form-label">Featured</label>
                            <select class="form-select" id="featured" name="featured">
                                <option value="">All Products</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                                <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="quantity" {{ request('sort') == 'quantity' ? 'selected' : '' }}>Quantity</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <form id="bulkActionForm" method="POST" action="{{ route('products.bulk-action') }}" class="d-inline">
                        @csrf
                        <div class="d-flex align-items-center">
                            <select name="action" class="form-select me-2" style="width: auto;">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate</option>
                                <option value="deactivate">Deactivate</option>
                                <option value="feature">Mark as Featured</option>
                                <option value="unfeature">Unmark as Featured</option>
                                <option value="delete">Delete</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary" id="bulkActionBtn" disabled>
                                Apply
                            </button>
                        </div>
                    </form>
                </div>
                <div>
                    <span class="text-muted">{{ $products->total() }} products found</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card product-card h-100">
                <div class="position-relative">
                    <img src="{{ $product->main_image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="form-check">
                            <input class="form-check-input product-checkbox" type="checkbox" value="{{ $product->id }}" id="product{{ $product->id }}">
                        </div>
                    </div>
                    @if($product->featured)
                        <div class="position-absolute top-0 start-0 p-2">
                            <span class="badge bg-warning">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        </div>
                    @endif
                    @if($product->discount_percentage > 0)
                        <div class="position-absolute bottom-0 start-0 p-2">
                            <span class="badge bg-danger">-{{ $product->discount_percentage }}%</span>
                        </div>
                    @endif
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-{{ $product->status_badge }}">{{ ucfirst($product->status) }}</span>
                        <span class="badge bg-secondary">{{ $product->category->name ?? 'No Category' }}</span>
                    </div>
                    <h6 class="card-title">{{ $product->name }}</h6>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    <div class="mb-2">
                        <strong class="text-primary">{{ $product->formatted_price }}</strong>
                        @if($product->compare_price)
                            <small class="text-muted text-decoration-line-through ms-1">{{ $product->formatted_compare_price }}</small>
                        @endif
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-box me-1"></i>{{ $product->quantity }} in stock
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-barcode me-1"></i>{{ $product->sku }}
                        </small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-success btn-sm flex-fill">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline flex-fill" 
                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-box fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No products found</h5>
                <p class="text-muted">Try adjusting your search criteria or add a new product.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Your First Product
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Bulk actions functionality
    const checkboxes = document.querySelectorAll('.product-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const bulkActionForm = document.getElementById('bulkActionForm');

    function updateBulkActionButton() {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        bulkActionBtn.disabled = checkedBoxes.length === 0;
        
        if (checkedBoxes.length > 0) {
            bulkActionBtn.textContent = `Apply (${checkedBoxes.length})`;
        } else {
            bulkActionBtn.textContent = 'Apply';
        }
    }

    // Add event listeners to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActionButton);
    });

    // Handle bulk action form submission
    bulkActionForm.addEventListener('submit', function(e) {
        const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
        const action = this.querySelector('select[name="action"]').value;
        
        if (checkedBoxes.length === 0) {
            e.preventDefault();
            alert('Please select at least one product.');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }
        
        // Add selected product IDs to form
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product_ids[]';
            input.value = checkbox.value;
            this.appendChild(input);
        });
        
        // Confirm destructive actions
        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${checkedBoxes.length} product(s)?`)) {
                e.preventDefault();
                return;
            }
        }
    });

    // Select all functionality
    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.product-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        
        updateBulkActionButton();
    }

    // Add select all checkbox to the page
    document.addEventListener('DOMContentLoaded', function() {
        const bulkActionsDiv = document.querySelector('.d-flex.justify-content-between.align-items-center');
        if (bulkActionsDiv) {
            const selectAllDiv = document.createElement('div');
            selectAllDiv.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                    <label class="form-check-label" for="selectAll">
                        Select All
                    </label>
                </div>
            `;
            bulkActionsDiv.insertBefore(selectAllDiv, bulkActionsDiv.firstChild);
        }
    });
</script>
@endsection

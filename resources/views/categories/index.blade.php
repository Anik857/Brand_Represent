@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Categories</h1>
      <p class="text-muted">Manage product categories and organize your inventory</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
      <i class="fas fa-plus me-2"></i>Create Category
    </a>
  </div>

  <!-- Filters -->
  <div class="card mb-4">
    <div class="card-body">
      <form method="GET" action="{{ route('categories.index') }}" class="row g-3">
        <div class="col-md-4">
          <label for="search" class="form-label">Search</label>
          <input type="text" class="form-control" id="search" name="search" 
                 value="{{ request('search') }}" placeholder="Category name, description, slug...">
        </div>
        <div class="col-md-2">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="featured" class="form-label">Featured</label>
          <select class="form-select" id="featured" name="featured">
            <option value="">All Categories</option>
            <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
            <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Not Featured</option>
          </select>
        </div>
        <div class="col-md-2">
          <label for="sort" class="form-label">Sort By</label>
          <select class="form-select" id="sort" name="sort">
            <option value="sort_order" {{ request('sort') == 'sort_order' ? 'selected' : '' }}>Sort Order</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
            <option value="products_count" {{ request('sort') == 'products_count' ? 'selected' : '' }}>Products Count</option>
          </select>
        </div>
        <div class="col-md-2">
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

  <!-- Categories Grid -->
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Categories ({{ $categories->total() }})</h5>
        <div class="d-flex gap-2">
          <select class="form-select form-select-sm" id="bulkAction" style="width: auto;">
            <option value="">Bulk Actions</option>
            <option value="activate">Activate</option>
            <option value="deactivate">Deactivate</option>
            <option value="feature">Mark as Featured</option>
            <option value="unfeature">Remove from Featured</option>
            <option value="delete">Delete</option>
          </select>
          <button type="button" class="btn btn-sm btn-outline-primary" onclick="applyBulkAction()">
            Apply
          </button>
        </div>
      </div>
    </div>
    <div class="card-body">
      @if($categories->count() > 0)
        <div class="row g-4">
          @foreach($categories as $category)
          <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="category-card">
              <div class="category-image">
                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="img-fluid">
                <div class="category-overlay">
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('categories.show', $category) }}" class="btn btn-light" title="View">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-light" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-light" 
                            onclick="deleteCategory({{ $category->id }})" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="category-content">
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <h6 class="category-name mb-0">{{ $category->name }}</h6>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input category-checkbox" value="{{ $category->id }}">
                  </div>
                </div>
                <p class="category-description text-muted small mb-2">
                  {{ Str::limit($category->description, 80) }}
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="category-badges">
                    <span class="badge bg-{{ $category->status_badge }} me-1">
                      {{ ucfirst($category->status) }}
                    </span>
                    @if($category->featured)
                    <span class="badge bg-{{ $category->featured_badge }}">
                      Featured
                    </span>
                    @endif
                  </div>
                  <small class="text-muted">
                    {{ $category->products_count }} products
                  </small>
                </div>
                <div class="mt-2">
                  <small class="text-muted">Sort Order: {{ $category->sort_order }}</small>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-5">
          <div class="text-muted">
            <i class="fas fa-tags fa-3x mb-3"></i>
            <p>No categories found</p>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
              Create First Category
            </a>
          </div>
        </div>
      @endif
    </div>
    @if($categories->hasPages())
    <div class="card-footer">
      {{ $categories->links() }}
    </div>
    @endif
  </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="{{ route('categories.bulk-action') }}" style="display: none;">
  @csrf
  <input type="hidden" name="action" id="bulkActionValue">
  <div id="bulkCategoryIds"></div>
</form>
@endsection

@section('styles')
<style>
  .category-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
  }

  .category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }

  .category-image {
    position: relative;
    height: 200px;
    overflow: hidden;
  }

  .category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .category-card:hover .category-image img {
    transform: scale(1.05);
  }

  .category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .category-card:hover .category-overlay {
    opacity: 1;
  }

  .category-content {
    padding: 1rem;
  }

  .category-name {
    font-weight: 600;
    color: #1f2937;
  }

  .category-description {
    line-height: 1.4;
  }

  .category-badges .badge {
    font-size: 0.75rem;
  }
</style>
@endsection

@section('scripts')
<script>
  // Select All functionality
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.category-checkbox');
    const selectAllCheckbox = document.createElement('input');
    selectAllCheckbox.type = 'checkbox';
    selectAllCheckbox.className = 'form-check-input';
    selectAllCheckbox.id = 'selectAll';
    
    // Add select all checkbox to the first category card
    const firstCard = document.querySelector('.category-card');
    if (firstCard) {
      const formCheck = firstCard.querySelector('.form-check');
      if (formCheck) {
        formCheck.insertBefore(selectAllCheckbox, formCheck.firstChild);
        formCheck.insertBefore(document.createElement('label'), selectAllCheckbox.nextSibling);
        formCheck.querySelector('label').setAttribute('for', 'selectAll');
        formCheck.querySelector('label').textContent = 'Select All';
      }
    }

    selectAllCheckbox.addEventListener('change', function() {
      checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
      });
    });

    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
        selectAllCheckbox.checked = checkboxes.length === checkedBoxes.length;
      });
    });
  });

  // Delete category
  function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category?')) {
      const form = document.getElementById('deleteForm');
      form.action = `/categories/${categoryId}`;
      form.submit();
    }
  }

  // Bulk actions
  function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    const checkedBoxes = document.querySelectorAll('.category-checkbox:checked');
    
    if (!action) {
      alert('Please select an action');
      return;
    }
    
    if (checkedBoxes.length === 0) {
      alert('Please select at least one category');
      return;
    }
    
    if (action === 'delete' && !confirm('Are you sure you want to delete the selected categories?')) {
      return;
    }
    
    const form = document.getElementById('bulkActionForm');
    document.getElementById('bulkActionValue').value = action;
    
    const categoryIdsContainer = document.getElementById('bulkCategoryIds');
    categoryIdsContainer.innerHTML = '';
    
    checkedBoxes.forEach(checkbox => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'category_ids[]';
      input.value = checkbox.value;
      categoryIdsContainer.appendChild(input);
    });
    
    form.submit();
  }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Add New Product')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Add New Product</h4>
          <p class="text-muted mb-0">Create a new product for your store</p>
        </div>
        <div>
          <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Products
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <!-- Main Form -->
      <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Basic Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="mb-3">
                  <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('sku') is-invalid @enderror"
                    id="sku" name="sku" value="{{ old('sku') }}" required>
                  @error('sku')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror"
                id="description" name="description" rows="4">{{ old('description') }}</textarea>
              @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Pricing -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Pricing</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                      id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="compare_price" class="form-label">Compare at Price</label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" class="form-control @error('compare_price') is-invalid @enderror"
                      id="compare_price" name="compare_price" value="{{ old('compare_price') }}">
                    @error('compare_price')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Inventory -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Inventory</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                  <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                    id="quantity" name="quantity" value="{{ old('quantity', 0) }}" required>
                  @error('quantity')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="weight" class="form-label">Weight (lbs)</label>
                  <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror"
                    id="weight" name="weight" value="{{ old('weight') }}">
                  @error('weight')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="dimensions" class="form-label">Dimensions (L x W x H)</label>
              <input type="text" class="form-control @error('dimensions') is-invalid @enderror"
                id="dimensions" name="dimensions" value="{{ old('dimensions') }}"
                placeholder="e.g., 10 x 8 x 2">
              @error('dimensions')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Product Images -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Product Images</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="images" class="form-label">Upload Images</label>
              <input type="file" class="form-control @error('images') is-invalid @enderror"
                id="images" name="images[]" multiple accept="image/*">
              <div class="form-text">You can upload multiple images. Supported formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB per image.</div>
              @error('images')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Image Preview Area -->
            <div id="imagePreview" class="row g-2">
              <!-- Preview images will be added here -->
            </div>

            <!-- Drag and Drop Area -->
            <div id="dropZone" class="border-2 border-dashed border-secondary rounded p-4 text-center"
              style="min-height: 150px; display: none;">
              <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
              <p class="text-muted">Drag and drop images here or click to browse</p>
              <input type="file" id="dropZoneInput" name="images[]" multiple accept="image/*" style="display: none;">
            </div>
          </div>
        </div>

        <!-- Variants -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Variants</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="available_colors" class="form-label">Available Colors</label>
                  <input type="text" class="form-control" id="available_colors" name="available_colors" value="{{ old('available_colors') }}" placeholder="e.g. Red, Blue, Green">
                  <div class="form-text">Comma-separated list of colors.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="available_sizes" class="form-label">Available Sizes</label>
                  <input type="text" class="form-control" id="available_sizes" name="available_sizes" value="{{ old('available_sizes') }}" placeholder="e.g. S, M, L, XL">
                  <div class="form-text">Comma-separated list of sizes.</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SEO -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">SEO</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="meta_title" class="form-label">Meta Title</label>
              <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
              @error('meta_title')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea class="form-control @error('meta_description') is-invalid @enderror"
                id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
              @error('meta_description')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Status -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Status</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="status" class="form-label">Product Status <span class="text-danger">*</span></label>
              <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                {{ old('featured') ? 'checked' : '' }}>
              <label class="form-check-label" for="featured">
                Featured Product
              </label>
            </div>
          </div>
        </div>

        <!-- Category & Brand -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Category & Brand</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
              <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
                @endforeach
              </select>
              @error('category_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="brand" class="form-label">Brand</label>
              <select class="form-select @error('brand') is-invalid @enderror" id="brand" name="brand">
                <option value="">Select Brand</option>
                @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>
                  {{ $brand }}
                </option>
                @endforeach
              </select>
              @error('brand')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create Product
              </button>
              <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
  // Auto-generate SKU from product name
  document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const skuField = document.getElementById('sku');

    if (!skuField.value) {
      const sku = name.toLowerCase()
        .replace(/[^a-z0-9\s]/g, '')
        .replace(/\s+/g, '-')
        .substring(0, 20);
      skuField.value = sku;
    }
  });

  // Calculate discount percentage
  function calculateDiscount() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const comparePrice = parseFloat(document.getElementById('compare_price').value) || 0;

    if (comparePrice > price && comparePrice > 0) {
      const discount = Math.round(((comparePrice - price) / comparePrice) * 100);
      console.log(`Discount: ${discount}%`);
    }
  }

  document.getElementById('price').addEventListener('input', calculateDiscount);
  document.getElementById('compare_price').addEventListener('input', calculateDiscount);

  // Image upload functionality
  const imageInput = document.getElementById('images');
  const imagePreview = document.getElementById('imagePreview');
  const dropZone = document.getElementById('dropZone');
  const dropZoneInput = document.getElementById('dropZoneInput');
  let uploadedImages = [];

  // File input change handler
  imageInput.addEventListener('change', handleFiles);

  // Drag and drop functionality
  dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-primary', 'bg-light');
  });

  dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-primary', 'bg-light');
  });

  dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-primary', 'bg-light');
    const files = e.dataTransfer.files;
    handleFiles({
      target: {
        files
      }
    });
  });

  dropZone.addEventListener('click', () => {
    dropZoneInput.click();
  });

  dropZoneInput.addEventListener('change', handleFiles);

  function handleFiles(event) {
    const files = Array.from(event.target.files);

    files.forEach(file => {
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
          addImagePreview(e.target.result, file);
        };
        reader.readAsDataURL(file);
      }
    });
  }

  function addImagePreview(src, file) {
    const col = document.createElement('div');
    col.className = 'col-md-3 col-sm-4 col-6';

    col.innerHTML = `
            <div class="position-relative">
                <img src="${src}" class="img-fluid rounded" style="height: 120px; object-fit: cover; width: 100%;">
                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" 
                        onclick="removeImagePreview(this)" title="Remove image">
                    <i class="fas fa-times"></i>
                </button>
                <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-1">
                    <small>${file.name}</small>
                </div>
            </div>
        `;

    imagePreview.appendChild(col);
    uploadedImages.push(file);

    // Show drop zone if no images
    if (imagePreview.children.length === 0) {
      dropZone.style.display = 'block';
    } else {
      dropZone.style.display = 'none';
    }
  }

  function removeImagePreview(button) {
    const col = button.closest('.col-md-3');
    const index = Array.from(imagePreview.children).indexOf(col);

    if (index > -1) {
      uploadedImages.splice(index, 1);
      col.remove();
    }

    // Show drop zone if no images
    if (imagePreview.children.length === 0) {
      dropZone.style.display = 'block';
    }
  }

  // Show drop zone initially
  dropZone.style.display = 'block';
</script>
@endsection
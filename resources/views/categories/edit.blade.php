@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Edit Category</h1>
      <p class="text-muted">Update category information</p>
    </div>
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
      <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
  </div>

  <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
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
                  <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" 
                         id="name" name="name" value="{{ old('name', $category->name) }}" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="sort_order" class="form-label">Sort Order</label>
                  <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                         id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                  @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <div class="form-text">Lower numbers appear first</div>
                </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
              @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Category Image -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Category Image</h5>
          </div>
          <div class="card-body">
            @if($category->image)
              <div class="mb-3 text-center">
                <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" class="img-fluid rounded" style="max-height: 200px;">
              </div>
            @endif
            <div class="mb-3">
              <label for="image" class="form-label">Upload New Image</label>
              <input type="file" class="form-control @error('image') is-invalid @enderror" 
                     id="image" name="image" accept="image/*">
              <div class="form-text">Recommended size: 300x200px. Supported formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB.</div>
              @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <!-- Image Preview -->
            <div id="imagePreview" class="text-center" style="display: none;">
              <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
            </div>
          </div>
        </div>

        <!-- SEO -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">SEO Settings</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="meta_title" class="form-label">Meta Title</label>
              <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                     id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}" maxlength="255">
              @error('meta_title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Meta Description</label>
              <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                        id="meta_description" name="meta_description" rows="3" maxlength="500">{{ old('meta_description', $category->meta_description) }}</textarea>
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
              <label for="status" class="form-label">Category Status</label>
              <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" 
                     {{ old('featured', $category->featured) ? 'checked' : '' }}>
              <label class="form-check-label" for="featured">
                Featured Category
              </label>
              <div class="form-text">Featured categories appear prominently</div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Category
              </button>
              <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                Cancel
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
  // Image preview
  document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('imagePreview').style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      document.getElementById('imagePreview').style.display = 'none';
    }
  });
</script>
@endsection

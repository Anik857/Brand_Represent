@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Create New Permission</h4>
          <p class="text-muted mb-0">Create a new system permission</p>
        </div>
        <div>
          <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Permissions
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('permissions.store') }}">
    @csrf
    <div class="row">
      <!-- Main Form -->
      <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Permission Information</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name') }}" 
                placeholder="e.g., view products, create users" required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Use lowercase with spaces (e.g., "view products", "create users")</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Actions -->
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create Permission
              </button>
              <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-times me-2"></i>Cancel
              </a>
            </div>
          </div>
        </div>

        <!-- Help -->
        <div class="card">
          <div class="card-header">
            <h5 class="mb-0">Permission Guidelines</h5>
          </div>
          <div class="card-body">
            <ul class="list-unstyled small">
              <li><i class="fas fa-check text-success me-2"></i>Use descriptive names</li>
              <li><i class="fas fa-check text-success me-2"></i>Use lowercase with spaces</li>
              <li><i class="fas fa-check text-success me-2"></i>Be specific about actions</li>
              <li><i class="fas fa-check text-success me-2"></i>Examples: "view products", "create users"</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

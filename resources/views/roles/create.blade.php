@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Create New Role</h4>
          <p class="text-muted mb-0">Create a new role with specific permissions</p>
        </div>
        <div>
          <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('roles.store') }}">
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
            <div class="mb-3">
              <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('name') is-invalid @enderror"
                id="name" name="name" value="{{ old('name') }}" required>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Permissions -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Permissions</h5>
          </div>
          <div class="card-body">
            @foreach($permissions as $category => $categoryPermissions)
            <div class="mb-3">
              <h6 class="text-primary">{{ ucfirst($category) }}</h6>
              @foreach($categoryPermissions as $permission)
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" 
                  value="{{ $permission->name }}" id="permission_{{ $permission->id }}"
                  {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="permission_{{ $permission->id }}">
                  {{ $permission->name }}
                </label>
              </div>
              @endforeach
            </div>
            @endforeach
          </div>
        </div>

        <!-- Actions -->
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create Role
              </button>
              <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
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
  // Select all permissions in a category
  function selectAllInCategory(category) {
    const checkboxes = document.querySelectorAll(`input[name="permissions[]"][data-category="${category}"]`);
    const selectAllCheckbox = document.getElementById(`select_all_${category}`);
    
    checkboxes.forEach(checkbox => {
      checkbox.checked = selectAllCheckbox.checked;
    });
  }
</script>
@endsection

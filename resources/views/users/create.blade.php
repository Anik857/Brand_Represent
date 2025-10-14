@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Create New User</h4>
          <p class="text-muted mb-0">Add a new user to the system</p>
        </div>
        <div>
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
          </a>
        </div>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('users.store') }}">
    @csrf
    <div class="row">
      <!-- Main Form -->
      <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">User Information</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" value="{{ old('email') }}" required>
                  @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password" name="password" required>
                  @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- Roles -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Assign Roles</h5>
          </div>
          <div class="card-body">
            @if($roles->count() > 0)
              @foreach($roles as $role)
              <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="roles[]" 
                  value="{{ $role->id }}" id="role_{{ $role->id }}"
                  {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="role_{{ $role->id }}">
                  {{ ucfirst($role->name) }}
                </label>
              </div>
              @endforeach
            @else
              <p class="text-muted">No roles available</p>
            @endif
          </div>
        </div>

        <!-- Actions -->
        <div class="card">
          <div class="card-body">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Create User
              </button>
              <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
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

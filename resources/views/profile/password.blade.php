@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Change Password</h1>
      <p class="text-muted">Update your account password</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Profile
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Password Settings</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" 
                     class="form-control @error('current_password') is-invalid @enderror" 
                     id="current_password" 
                     name="current_password" 
                     required>
              @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" 
                     class="form-control @error('password') is-invalid @enderror" 
                     id="password" 
                     name="password" 
                     required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Password must be at least 6 characters long.</div>
            </div>

            <div class="mb-4">
              <label for="password_confirmation" class="form-label">Confirm New Password</label>
              <input type="password" 
                     class="form-control" 
                     id="password_confirmation" 
                     name="password_confirmation" 
                     required>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-key me-2"></i>Update Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Password Tips -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Password Tips</h5>
        </div>
        <div class="card-body">
          <ul class="list-unstyled mb-0">
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Use at least 6 characters
            </li>
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Include uppercase and lowercase letters
            </li>
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Add numbers and special characters
            </li>
            <li class="mb-2">
              <i class="fas fa-check text-success me-2"></i>
              Avoid common words or phrases
            </li>
            <li class="mb-0">
              <i class="fas fa-check text-success me-2"></i>
              Don't reuse old passwords
            </li>
          </ul>
        </div>
      </div>

      <!-- Security Notice -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Security Notice</h5>
        </div>
        <div class="card-body">
          <div class="alert alert-info mb-0">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Important:</strong> After changing your password, you'll need to log in again with your new password.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

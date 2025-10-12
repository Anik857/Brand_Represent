@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Edit Profile</h1>
      <p class="text-muted">Update your account information</p>
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
          <h5 class="mb-0">Profile Information</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" 
                         class="form-control @error('name') is-invalid @enderror" 
                         id="name" 
                         name="name" 
                         value="{{ old('name', $user->name) }}" 
                         required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input type="email" 
                         class="form-control @error('email') is-invalid @enderror" 
                         id="email" 
                         name="email" 
                         value="{{ old('email', $user->email) }}" 
                         required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">
                Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Update Profile
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Profile Picture -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Profile Picture</h5>
        </div>
        <div class="card-body text-center">
          <div class="profile-picture mb-3">
            <div class="avatar-circle">
              <i class="fas fa-user"></i>
            </div>
          </div>
          <p class="text-muted">Profile pictures coming soon!</p>
        </div>
      </div>

      <!-- Account Information -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Account Information</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label class="form-label text-muted">Account Created</label>
            <p class="mb-0 fw-medium">{{ $user->created_at->format('M d, Y') }}</p>
          </div>
          <div class="mb-3">
            <label class="form-label text-muted">Last Updated</label>
            <p class="mb-0 fw-medium">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
          </div>
          <div class="mb-0">
            <label class="form-label text-muted">User ID</label>
            <p class="mb-0 fw-medium">#{{ $user->id }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('styles')
<style>
  .profile-picture {
    display: flex;
    justify-content: center;
  }
  
  .avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
  }
</style>
@endsection

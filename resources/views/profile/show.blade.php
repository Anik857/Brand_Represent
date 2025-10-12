@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">My Profile</h1>
      <p class="text-muted">Manage your account information and settings</p>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('profile.edit') }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>Edit Profile
      </a>
      <a href="{{ route('profile.password') }}" class="btn btn-outline-secondary">
        <i class="fas fa-key me-2"></i>Change Password
      </a>
    </div>
  </div>

  <div class="row">
    <!-- Profile Information -->
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Profile Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label text-muted">Full Name</label>
                <p class="mb-0 fw-medium">{{ $user->name }}</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label text-muted">Email Address</label>
                <p class="mb-0 fw-medium">{{ $user->email }}</p>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label text-muted">Account Created</label>
                <p class="mb-0 fw-medium">{{ $user->created_at->format('M d, Y') }}</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label text-muted">Last Updated</label>
                <p class="mb-0 fw-medium">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Account Statistics -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Account Statistics</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="text-center">
                <div class="stats-icon primary mb-3">
                  <i class="fas fa-box"></i>
                </div>
                <h4 class="mb-1">{{ \App\Models\Product::count() }}</h4>
                <p class="text-muted mb-0">Total Products</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="text-center">
                <div class="stats-icon success mb-3">
                  <i class="fas fa-shopping-cart"></i>
                </div>
                <h4 class="mb-1">{{ \App\Models\Order::count() }}</h4>
                <p class="text-muted mb-0">Total Orders</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="text-center">
                <div class="stats-icon warning mb-3">
                  <i class="fas fa-clock"></i>
                </div>
                <h4 class="mb-1">{{ \App\Models\Order::pending()->count() }}</h4>
                <p class="text-muted mb-0">Pending Orders</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Profile Actions -->
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

      <!-- Quick Actions -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
              <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-success">
              <i class="fas fa-box me-2"></i>Manage Products
            </a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-info">
              <i class="fas fa-shopping-cart me-2"></i>View Orders
            </a>
          </div>
        </div>
      </div>

      <!-- Account Security -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Account Security</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h6 class="mb-1">Password</h6>
              <small class="text-muted">Last changed: Never</small>
            </div>
            <a href="{{ route('profile.password') }}" class="btn btn-sm btn-outline-primary">
              Change
            </a>
          </div>
          
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-1">Two-Factor Auth</h6>
              <small class="text-muted">Not enabled</small>
            </div>
            <button class="btn btn-sm btn-outline-secondary" disabled>
              Enable
            </button>
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
  
  .stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 1.5rem;
    color: white;
  }
  
  .stats-icon.primary {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
  }
  
  .stats-icon.success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  }
  
  .stats-icon.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  }
</style>
@endsection

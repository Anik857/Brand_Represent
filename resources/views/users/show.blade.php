@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">User Details: {{ $user->name }}</h4>
          <p class="text-muted mb-0">View user information and assigned roles</p>
        </div>
        <div>
          <a href="{{ route('users.edit', $user) }}" class="btn btn-success me-2">
            <i class="fas fa-edit me-2"></i>Edit User
          </a>
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- User Information -->
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">User Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Name:</strong></td>
                  <td>{{ $user->name }}</td>
                </tr>
                <tr>
                  <td><strong>Email:</strong></td>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <td><strong>Created:</strong></td>
                  <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Updated:</strong></td>
                  <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Roles Count:</strong></td>
                  <td>
                    <span class="badge bg-success">{{ $user->roles->count() }} roles</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Assigned Roles -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Assigned Roles</h5>
        </div>
        <div class="card-body">
          @if($user->roles->count() > 0)
            <div class="row">
              @foreach($user->roles as $role)
              <div class="col-md-6 mb-3">
                <div class="card border">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                        {{ strtoupper(substr($role->name, 0, 1)) }}
                      </div>
                      <div>
                        <h6 class="mb-0">{{ ucfirst($role->name) }}</h6>
                        <small class="text-muted">{{ $role->permissions->count() }} permissions</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-3">
              <i class="fas fa-shield-alt fa-2x text-muted mb-2"></i>
              <p class="text-muted">This user has no roles assigned</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- User Avatar -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">User Profile</h5>
        </div>
        <div class="card-body text-center">
          <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
            {{ strtoupper(substr($user->name, 0, 2)) }}
          </div>
          <h5>{{ $user->name }}</h5>
          <p class="text-muted">{{ $user->email }}</p>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('users.edit', $user) }}" class="btn btn-success">
              <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">
              <i class="fas fa-shield-alt me-2"></i>Manage Roles
            </a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fas fa-trash me-2"></i>Delete User
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Statistics -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Statistics</h5>
        </div>
        <div class="card-body">
          <div class="row text-center">
            <div class="col-6">
              <h4 class="text-primary">{{ $user->roles->count() }}</h4>
              <small class="text-muted">Roles</small>
            </div>
            <div class="col-6">
              <h4 class="text-success">{{ $user->created_at->diffInDays(now()) }}</h4>
              <small class="text-muted">Days Active</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

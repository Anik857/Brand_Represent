@extends('layouts.app')

@section('title', 'Permission Details')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Permission Details: {{ $permission->name }}</h4>
          <p class="text-muted mb-0">View permission information and assigned roles</p>
        </div>
        <div>
          <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-success me-2">
            <i class="fas fa-edit me-2"></i>Edit Permission
          </a>
          <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Permissions
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Permission Information -->
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Permission Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Permission Name:</strong></td>
                  <td>{{ $permission->name }}</td>
                </tr>
                <tr>
                  <td><strong>Category:</strong></td>
                  <td>
                    <span class="badge bg-info">{{ ucfirst($permission->category ?? 'General') }}</span>
                  </td>
                </tr>
                <tr>
                  <td><strong>Created:</strong></td>
                  <td>{{ $permission->created_at->format('M d, Y H:i') }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Updated:</strong></td>
                  <td>{{ $permission->updated_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Roles Count:</strong></td>
                  <td>
                    <span class="badge bg-success">{{ $permission->roles->count() }} roles</span>
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
          @if($permission->roles->count() > 0)
            <div class="row">
              @foreach($permission->roles as $role)
              <div class="col-md-6 mb-3">
                <div class="card border">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                        {{ strtoupper(substr($role->name, 0, 1)) }}
                      </div>
                      <div>
                        <h6 class="mb-0">{{ ucfirst($role->name) }}</h6>
                        <small class="text-muted">{{ $role->users->count() }} users</small>
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
              <p class="text-muted">This permission is not assigned to any roles</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Quick Actions -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-success">
              <i class="fas fa-edit me-2"></i>Edit Permission
            </a>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">
              <i class="fas fa-shield-alt me-2"></i>Manage Roles
            </a>
            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fas fa-trash me-2"></i>Delete Permission
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
              <h4 class="text-primary">{{ $permission->roles->count() }}</h4>
              <small class="text-muted">Roles</small>
            </div>
            <div class="col-6">
              <h4 class="text-success">{{ $permission->users->count() }}</h4>
              <small class="text-muted">Users</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

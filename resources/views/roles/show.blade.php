@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Role Details: {{ ucfirst($role->name) }}</h4>
          <p class="text-muted mb-0">View role information and permissions</p>
        </div>
        <div>
          <a href="{{ route('roles.edit', $role) }}" class="btn btn-success me-2">
            <i class="fas fa-edit me-2"></i>Edit Role
          </a>
          <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Roles
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Role Information -->
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Role Information</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Role Name:</strong></td>
                  <td>{{ ucfirst($role->name) }}</td>
                </tr>
                <tr>
                  <td><strong>Created:</strong></td>
                  <td>{{ $role->created_at->format('M d, Y H:i') }}</td>
                </tr>
                <tr>
                  <td><strong>Updated:</strong></td>
                  <td>{{ $role->updated_at->format('M d, Y H:i') }}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <td><strong>Users Count:</strong></td>
                  <td>
                    <span class="badge bg-info">{{ $role->users->count() }} users</span>
                  </td>
                </tr>
                <tr>
                  <td><strong>Permissions Count:</strong></td>
                  <td>
                    <span class="badge bg-success">{{ $role->permissions->count() }} permissions</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Permissions -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Assigned Permissions</h5>
        </div>
        <div class="card-body">
          @if($role->permissions->count() > 0)
            <div class="row">
              @foreach($role->permissions->groupBy('category') as $category => $permissions)
              <div class="col-md-6 mb-3">
                <h6 class="text-primary">{{ ucfirst($category) }}</h6>
                <div class="d-flex flex-wrap gap-1">
                  @foreach($permissions as $permission)
                    <span class="badge bg-secondary">{{ $permission->name }}</span>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
          @else
            <div class="text-center py-3">
              <i class="fas fa-shield-alt fa-2x text-muted mb-2"></i>
              <p class="text-muted">No permissions assigned to this role</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
      <!-- Users with this role -->
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Users with this Role</h5>
        </div>
        <div class="card-body">
          @if($role->users->count() > 0)
            @foreach($role->users as $user)
            <div class="d-flex align-items-center mb-2">
              <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <div>
                <h6 class="mb-0">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->email }}</small>
              </div>
            </div>
            @endforeach
          @else
            <div class="text-center py-3">
              <i class="fas fa-users fa-2x text-muted mb-2"></i>
              <p class="text-muted">No users assigned to this role</p>
            </div>
          @endif
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
          <div class="d-grid gap-2">
            <a href="{{ route('roles.edit', $role) }}" class="btn btn-success">
              <i class="fas fa-edit me-2"></i>Edit Role
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
              <i class="fas fa-users me-2"></i>Manage Users
            </a>
            @if($role->name !== 'admin')
            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger w-100">
                <i class="fas fa-trash me-2"></i>Delete Role
              </button>
            </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Roles Management</h4>
          <p class="text-muted mb-0">Manage user roles and their permissions</p>
        </div>
        <div>
          <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Role
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Roles Table -->
  <div class="card">
    <div class="card-body">
      @if($roles->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Permissions</th>
                <th>Users Count</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($roles as $role)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      {{ strtoupper(substr($role->name, 0, 1)) }}
                    </div>
                    <div>
                      <h6 class="mb-0">{{ ucfirst($role->name) }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  @if($role->permissions->count() > 0)
                    <div class="d-flex flex-wrap gap-1">
                      @foreach($role->permissions->take(3) as $permission)
                        <span class="badge bg-secondary">{{ $permission->name }}</span>
                      @endforeach
                      @if($role->permissions->count() > 3)
                        <span class="badge bg-light text-dark">+{{ $role->permissions->count() - 3 }} more</span>
                      @endif
                    </div>
                  @else
                    <span class="text-muted">No permissions</span>
                  @endif
                </td>
                <td>
                  <span class="badge bg-info">{{ $role->users->count() }} users</span>
                </td>
                <td>{{ $role->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{ route('roles.show', $role) }}" class="btn btn-outline-primary btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-outline-success btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    @if($role->name !== 'admin')
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    @endif
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($roles->hasPages())
        <div class="card-footer">
          {{ $roles->links() }}
        </div>
        @endif
      @else
        <div class="text-center py-5">
          <div class="text-muted">
            <i class="fas fa-shield-alt fa-3x mb-3"></i>
            <p>No roles found</p>
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
              Create First Role
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

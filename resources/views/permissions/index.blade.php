@extends('layouts.app')

@section('title', 'Permissions Management')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Permissions Management</h4>
          <p class="text-muted mb-0">Manage system permissions</p>
        </div>
        <div>
          <a href="{{ route('permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Permission
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Permissions Table -->
  <div class="card">
    <div class="card-body">
      @if($permissions->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Roles Count</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($permissions as $permission)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      <i class="fas fa-key"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">{{ $permission->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="badge bg-info">{{ ucfirst($permission->category ?? 'General') }}</span>
                </td>
                <td>
                  <span class="badge bg-secondary">{{ $permission->roles->count() }} roles</span>
                </td>
                <td>{{ $permission->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-outline-primary btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-outline-success btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this permission?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($permissions->hasPages())
        <div class="card-footer">
          {{ $permissions->links() }}
        </div>
        @endif
      @else
        <div class="text-center py-5">
          <div class="text-muted">
            <i class="fas fa-key fa-3x mb-3"></i>
            <p>No permissions found</p>
            <a href="{{ route('permissions.create') }}" class="btn btn-primary">
              Create First Permission
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

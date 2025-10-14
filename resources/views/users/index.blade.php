@extends('layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Users Management</h4>
          <p class="text-muted mb-0">Manage system users and their roles</p>
        </div>
        <div>
          @can('create users')
          <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New User
          </a>
          @endcan
        </div>
      </div>
    </div>
  </div>

  <!-- Users Table -->
  <div class="card">
    <div class="card-body">
      @if($users->count() > 0)
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                      <h6 class="mb-0">{{ $user->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                  @if($user->roles->count() > 0)
                    @foreach($user->roles as $role)
                      <span class="badge bg-secondary me-1">{{ $role->name }}</span>
                    @endforeach
                  @else
                    <span class="text-muted">No roles assigned</span>
                  @endif
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td>
                  <div class="btn-group" role="group">
                    @can('view users')
                    <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                    @endcan
                    @can('edit users')
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-success btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    @endcan
                    @can('delete users')
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    @endcan
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @if($users->hasPages())
        <div class="card-footer">
          {{ $users->links() }}
        </div>
        @endif
      @else
        <div class="text-center py-5">
          <div class="text-muted">
            <i class="fas fa-users fa-3x mb-3"></i>
            <p>No users found</p>
            @can('create users')
            <a href="{{ route('users.create') }}" class="btn btn-primary">
              Create First User
            </a>
            @endcan
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection

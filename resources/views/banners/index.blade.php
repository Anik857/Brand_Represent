@extends('layouts.app')

@section('title', 'Banners')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1 class="h3 mb-0">Banners</h1>
      <p class="text-muted">Manage homepage banners</p>
    </div>
    <div>
      <a href="{{ route('banners.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add Banner</a>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Preview</th>
              <th>Key</th>
              <th>Title</th>
              <th>Active</th>
              <th>Order</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($banners as $banner)
            <tr>
              <td><img src="{{ $banner->image_url }}" alt="" style="width:100px;height:60px;object-fit:cover" class="rounded border"></td>
              <td><code>{{ $banner->key }}</code></td>
              <td>{{ $banner->title }}</td>
              <td>
                @if($banner->is_active)
                <span class="badge bg-success">Active</span>
                @else
                <span class="badge bg-secondary">Inactive</span>
                @endif
              </td>
              <td>{{ $banner->sort_order }}</td>
              <td>
                <a href="{{ route('banners.edit', $banner) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this banner?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center text-muted">No banners yet.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
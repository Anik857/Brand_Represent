@extends('layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Banner</h1>
    <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back</a>
  </div>

  <div class="card">
    <div class="card-body">
      @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <form method="POST" action="{{ route('banners.update', $banner) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Key</label>
              <input type="text" class="form-control" value="{{ $banner->key }}" disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title) }}">
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Link URL</label>
              <input type="url" name="link_url" class="form-control @error('link_url') is-invalid @enderror" value="{{ old('link_url', $banner->link_url) }}" placeholder="https://...">
              @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Active</label>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Visible on site</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Sort Order</label>
              <input type="number" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $banner->sort_order) }}" min="0">
              @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Current Image</label>
              <div>
                <img src="{{ $banner->image_url }}" alt="" style="max-width:100%;height:auto" class="rounded border">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Change Image</label>
              <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
              <div class="form-text">Leave empty to keep the current image.</div>
              @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
          <a href="{{ route('banners.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
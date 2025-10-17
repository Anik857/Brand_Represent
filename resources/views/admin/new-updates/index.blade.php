@extends('layouts.app')

@section('title', 'New Updates Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">New Updates Management</h1>
            <p class="text-muted">Manage your website updates and news posts</p>
        </div>
        <div>
            <a href="{{ route('admin.new-updates.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create New Update
            </a>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.new-updates.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text"
                                   class="form-control"
                                   id="search"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search by title or author...">
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="author" class="form-label">Author</label>
                            <select class="form-select" id="author" name="author">
                                <option value="">All Authors</option>
                                @foreach(\App\Models\Blog::distinct()->pluck('author') as $blogAuthor)
                                    <option value="{{ $blogAuthor }}" {{ request('author') == $blogAuthor ? 'selected' : '' }}>
                                        {{ $blogAuthor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                                <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>Most Viewed</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.new-updates.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $blogs->total() }}</h4>
                            <p class="mb-0">Total Updates</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $blogs->where('is_published', true)->count() }}</h4>
                            <p class="mb-0">Published</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $blogs->where('is_published', false)->count() }}</h4>
                            <p class="mb-0">Drafts</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="mb-0">{{ $blogs->sum('views') }}</h4>
                            <p class="mb-0">Total Views</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Updates Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Updates</h5>
        </div>
        <div class="card-body">
            @if($blogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td>
                                <img src="{{ Storage::url($blog->featured_image) }}" 
                                     alt="{{ $blog->title }}" 
                                     class="rounded" 
                                     style="width: 60px; height: 40px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-medium">{{ Str::limit($blog->title, 50) }}</div>
                                <small class="text-muted">{{ $blog->slug }}</small>
                            </td>
                            <td>{{ $blog->author }}</td>
                            <td>
                                @if($blog->is_published)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning">Draft</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $blog->views }}</span>
                            </td>
                            <td>{{ $blog->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.new-updates.show', $blog) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.new-updates.edit', $blog) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.new-updates.destroy', $blog) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this update?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Delete">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $blogs->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4>No updates found</h4>
                <p class="text-muted">Create your first update to get started.</p>
                <a href="{{ route('admin.new-updates.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create New Update
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

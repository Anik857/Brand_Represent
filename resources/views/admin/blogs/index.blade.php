@extends('layouts.app')

@section('title', 'Blog Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Blog Management</h1>
            <p class="text-muted">Manage your blog posts and updates</p>
        </div>
        <div>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create New Post
            </a>
        </div>
    </div>

    <!-- Blog Posts Table -->
    <div class="card">
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
                                    <a href="{{ route('admin.blogs.show', $blog) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $blog) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $blog) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this blog post?')">
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
                <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                <h4>No blog posts found</h4>
                <p class="text-muted">Create your first blog post to get started.</p>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create New Post
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

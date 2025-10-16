@extends('layouts.app')

@section('title', 'View Blog Post')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Blog Post Details</h1>
            <p class="text-muted">{{ $blog->title }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Post
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Blog Posts
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Blog Post Content -->
            <div class="card">
                <div class="card-body">
                    @if($blog->featured_image)
                    <div class="mb-4">
                        <img src="{{ Storage::url($blog->featured_image) }}" 
                             alt="{{ $blog->title }}" 
                             class="img-fluid rounded">
                    </div>
                    @endif

                    <div class="d-flex align-items-center mb-3">
                        <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-warning' }} me-3">
                            {{ $blog->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <span class="text-muted me-3">By {{ $blog->author }}</span>
                        <span class="text-muted me-3">{{ $blog->formatted_date }}</span>
                        <span class="text-muted">{{ $blog->views }} views</span>
                    </div>

                    <h2 class="mb-3">{{ $blog->title }}</h2>
                    
                    <div class="mb-4">
                        <h5>Excerpt:</h5>
                        <p class="text-muted">{{ $blog->excerpt }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Content:</h5>
                        <div class="blog-content">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Slug:</h5>
                        <code>{{ $blog->slug }}</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Blog Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary mb-0">{{ $blog->views }}</h4>
                            <small class="text-muted">Total Views</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $blog->created_at->format('M d') }}</h4>
                            <small class="text-muted">Created</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info mb-0">{{ $blog->updated_at->format('M d') }}</h4>
                            <small class="text-muted">Last Updated</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-0">{{ $blog->created_at->diffForHumans() }}</h4>
                            <small class="text-muted">Age</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('blogs.show', $blog) }}" 
                           class="btn btn-outline-primary" 
                           target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>View on Website
                        </a>
                        <a href="{{ route('admin.blogs.edit', $blog) }}" 
                           class="btn btn-outline-success">
                            <i class="fas fa-edit me-2"></i>Edit Post
                        </a>
                        <button type="button" 
                                class="btn btn-outline-danger" 
                                onclick="confirmDelete()">
                            <i class="fas fa-trash me-2"></i>Delete Post
                        </button>
                    </div>
                </div>
            </div>

            <!-- Blog Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Blog Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $blog->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $blog->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Author:</strong></td>
                            <td>{{ $blog->author }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-warning' }}">
                                    {{ $blog->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $blog->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $blog->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this blog post? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection

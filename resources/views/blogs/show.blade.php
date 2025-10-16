@extends('frontend.layout')

@section('title', $blog->title . ' - Blog')

@section('content')
<!-- ======================= Blog Detail Start ============================ -->
<section class="space min">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                <div class="_blog_wrap">
                    <div class="_blog_thumb mb-4">
                        <img src="{{ asset($blog->featured_image) }}" class="img-fluid rounded" alt="{{ $blog->title }}">
                    </div>
                    <div class="_blog_caption">
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-muted me-3">{{ $blog->formatted_date }}</span>
                            <span class="text-muted me-3">By {{ $blog->author }}</span>
                            <span class="text-muted">{{ $blog->views }} views</span>
                        </div>
                        <h1 class="bl_title mb-3">{{ $blog->title }}</h1>
                        <div class="blog_content">
                            {!! nl2br(e($blog->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                <div class="sidebar">
                    <!-- Related Posts -->
                    @if($relatedBlogs->count() > 0)
                    <div class="widget">
                        <h4 class="widget_title">Related Posts</h4>
                        <div class="widget_content">
                            @foreach($relatedBlogs as $relatedBlog)
                            <div class="d-flex align-items-center mb-3">
                                <div class="widget_thumb me-3">
                                    <a href="{{ route('blogs.show', $relatedBlog) }}">
                                        <img src="{{ asset($relatedBlog->featured_image) }}" class="img-fluid rounded" alt="{{ $relatedBlog->title }}" style="width: 80px; height: 60px; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="widget_caption">
                                    <h6 class="mb-1">
                                        <a href="{{ route('blogs.show', $relatedBlog) }}" class="text-dark">{{ $relatedBlog->short_title }}</a>
                                    </h6>
                                    <small class="text-muted">{{ $relatedBlog->formatted_date }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Back to Blog -->
                    <div class="widget">
                        <div class="widget_content">
                            <a href="{{ route('blogs.index') }}" class="btn btn-primary">
                                <i class="lni lni-arrow-left me-2"></i>Back to Blog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======================= Blog Detail End ============================ -->
@endsection

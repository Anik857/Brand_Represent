@extends('frontend.layout')

@section('title', 'Blog - Latest Updates')

@section('content')
<!-- ======================= Blog Start ============================ -->
<section class="space min">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="sec_title position-relative text-center">
                    <h2 class="off_title">Latest News</h2>
                    <h3 class="ft-bold pt-3">New Updates</h3>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($blogs as $blog)
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="_blog_wrap">
                    <div class="_blog_thumb mb-2">
                        <a href="{{ route('blogs.show', $blog) }}" class="d-block">
                            <img src="{{ asset($blog->featured_image) }}" class="img-fluid rounded" alt="{{ $blog->title }}">
                        </a>
                    </div>
                    <div class="_blog_caption">
                        <span class="text-muted">{{ $blog->formatted_date }}</span>
                        <h5 class="bl_title lh-1">
                            <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                        </h5>
                        <p>{{ $blog->excerpt }}</p>
                        <a href="{{ route('blogs.show', $blog) }}" class="text-dark fs-sm">Continue Reading..</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4>No blog posts available</h4>
                    <p class="text-muted">Check back later for updates!</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- ======================= Blog End ============================ -->
@endsection

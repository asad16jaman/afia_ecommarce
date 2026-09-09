@extends('front.layout.app')
@section('title', 'Blogs Page')
@push('style')
    <style>
        
    </style>
@endpush

@section('content')
    <section class="blog-section header_margin">
        <div class="container py-4">
            <div class="text-center">
                <h2 class="fw-bold mb-2">All Blogs</h2>
            </div>

            <div class="row d-flex justify-content-center">
                  @foreach ($blogs as $blog)
                        <div class="col-12 col-md-4 mt-0 mb-3">
                        <a href="{{ route('get_blog', ['slug' => $blog->slug]) }}">
                            <div class="card border-0 rounded-4">
                            <div class="card-body p-2">
                                <div class="mb-3">
                                    <img src="{{ $blog->image ? $softUrl . $blog->image : asset('assets/images/blog/b1.jpg') }}" alt="{{ $blog->title }}"
                                        class="img-fluid rounded-5 fixed-card-img">
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-nav bg-opacity-10 text-warning px-2 py-1 rounded-pill">Writer : {{ $blog->write_by }}</span>
                                </div>
                                <h5 class="card-title fw-bold mb-2">{{ $blog->title }}</h5>
                                <p class="card-text text-muted mb-0">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 160, '...') }}

                                </p>
                            </div>
                        </div>
                        </a>
                    </div>

                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('script')
    
@endpush
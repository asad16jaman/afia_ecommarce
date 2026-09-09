@extends('front.layout.app')
@section('title', $page->title)
@push('style')
    <style>


    </style>
@endpush

@section('content')

    <div class="header_margin">
        <section id="blog-content" class="">
            <div class="container">
                <div class="row gx-4 gx-lg-5 mb-4">
                    <!-- Main Content -->
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb custom-breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $page->title }}
                                </li>
                            </ol>
                        </nav>
                        <article class="mt-4">
                            <h1 class="fw-bold mb-4 article-title">
                                {{ $page->title }}
                            </h1>
                            <div>
                                {!! $page->description !!}
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection

@push('script')
    <script>

    </script>
@endpush
@extends('front.layout.app')
@section('title', 'Galleries Page')
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/photo_gallery.css') }}">
    <style>
        .gallery-filter {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .gallery-filter button {
            border: 1px solid #ddd;
            background: #fff;
            padding: 7px 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .gallery-filter button:hover,
        .gallery-filter button.active {
            background: var(--nav-color);
            color: #fff;
            border-color:  var(--nav-color);
        }
    </style>
@endpush

@section('content')
    <section class="galleries-section header_margin">
        <div class="container py-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-2">Galleries</h2>
            </div>
            <div>
                <div class="gallery-filter">
                    <button type="button" class="active" data-filter="*">All</button>
                    <button type="button" data-filter=".photo">
                        <i class="bi bi-camera"></i> Photos
                    </button>
                    <button type="button" data-filter=".video">
                        <i class="bi bi-youtube"></i> Videos
                    </button>
                </div>
            </div>
            <div class="row gallery-grid">
                @foreach ($galleries as $glry)
                    <div class="col-lg-4 col-md-6 col-6 mt-0 mb-3 gallery-item {{ $glry->type == 'p' ? 'photo' : 'video' }}">
                        <div class="gallery-card ">
                            <a href="{{ $glry->type == 'p' ? $softUrl . $glry->image : $glry->video }}" class="glightbox"
                                data-gallery="gallery1" data-description="{{ $glry->title }}">
                                @if ($glry->type == 'p')
                                    <span class="position-absolute top_bedge">
                                        <i class="bi bi-camera"></i> Photo
                                    </span>
                                @else
                                    <span class="position-absolute top_bedge_youtube">
                                        <i class="bi bi-youtube"></i> Video
                                    </span>
                                @endif
                                <div class="gallery-image">
                                    <img src="{{ $softUrl . $glry->image }}" alt="{{ $glry->title }}">
                                    <div class="gallery-overlay">
                                        <div class="gallery-content">
                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(optional($glry)->title), 30) }}
                                            </p>
                                        </div>
                                        <span class="gallery-icon ">
                                            <button class="plusBtn">
                                                @if ($glry->type == 'p')
                                                    <i class="bi bi-plus-lg"></i>
                                                @else
                                                    <i class="bi bi-eye"></i>
                                                @endif
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Isotope
            const galleryGrid = document.querySelector('.gallery-grid');
            const iso = new Isotope(galleryGrid, {
                itemSelector: '.gallery-item',
                layoutMode: 'fitRows'
            });
            // Filter
            document.querySelectorAll('.gallery-filter button').forEach(function (button) {
                button.addEventListener('click', function () {
                    const filterValue = this.getAttribute('data-filter');
                    iso.arrange({
                        filter: filterValue
                    });
                    // Active button
                    document.querySelectorAll('.gallery-filter button')
                        .forEach(function (btn) {
                            btn.classList.remove('active');
                        });
                    this.classList.add('active');
                });
            });
            // GLightbox
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
        });
    </script>
@endpush
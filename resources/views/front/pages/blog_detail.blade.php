@extends('front.layout.app')
@section('title', 'Blog Detail Page')
@push('style')
    <style>


    </style>
@endpush

@section('content')

            <div class="header_margin">
            <section id="blog-content" class="">
                <div class="container">
                    <div class="row gx-4 gx-lg-5">
                        <!-- Main Content -->
                        <div class="col-md-8">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb custom-breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('get_all_blog') }}">Blogs</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ $blog->title }}
                                    </li>
                                </ol>
                            </nav>
                            <article class="mt-4">
                                <h1 class="fw-bold mb-4 article-title">
                                {{ $blog->title }}
                                </h1>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/blog/male.jpeg') }}" alt="Author" class="rounded-circle me-2"
                                            width="40" height="40">
                                        <div>
                                            <small class="text-muted">{{ $blog->write_by }}</small><br>
                                            <small class="text-muted">{{ date_create($blog->created_at)->format('M d, Y') }} &nbsp; 6 MIN READ</small>
                                        </div>
                                    </div>
                                    <div class="blog-meta-icons d-flex align-items-center gap-3 me-5">
                                        <a href="#" class="meta-icon">
                                            <i class="bi bi-share"></i>
                                        </a>
                                        <a href="#" class="meta-icon">
                                            <i class="bi bi-bookmark"></i>
                                        </a>
                                    </div>
                                </div>
                                <img src="{{ $softUrl . $blog->image }}" alt="{{ $blog->title }}"
                                    class="img-fluid blog-image mx-auto d-block mb-4">
                                <div>
                                    {!! $blog->description !!}
                                </div>

                                <!-- <div class="d-flex justify-content-between align-items-center mb-4">
                                    <small class="fw-bold">Share this article:</small>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-facebook text-white rounded-pill">Facebook</a>
                                        <a href="#" class="btn btn-whatsapp text-white rounded-pill">WhatsApp</a>
                                    </div>
                                </div> -->
                            </article>

                            <!-- Comments Section -->
                            <!-- <div class="card mb-5">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-4">Leave a Reply</h5>
                                    <form>
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <input type="text" class="form-control rounded-pill py-2 px-4" id="name"
                                                    placeholder="Your Name" style="background-color: #F8F8F5; border: none;">
                                            </div>
                                            <div class="col-md-6">
                                                <input type="email" class="form-control rounded-pill py-2 px-4" id="email"
                                                    placeholder="Your Email" style="background-color: #F8F8F5; border: none;">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control rounded-3" id="comment" rows="3"
                                                placeholder="Write your comment here..."
                                                style="background-color: #F8F8F5; border: none;"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-warning rounded-pill text-black px-4">Post
                                            Comment</button>
                                    </form>

                                    <hr class="my-4">

                                    <div class="d-flex mb-3">
                                        <img src="images/images.png" alt="User" class="rounded-circle me-2" width="40" height="40">
                                        <div>
                                            <small class="fw-bold">Rafiq Islam</small><br>
                                            <small class="text-muted">2 days ago</small>
                                            <p class="mb-0">ভাই, আপনার টিপসগুলো অনেক কাজে লাগবে। ধন্যবাদ!</p>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <img src="images/images.png" alt="User" class="rounded-circle me-2" width="40" height="40">
                                        <div>
                                            <small class="fw-bold">Sadia Khan</small><br>
                                            <small class="text-muted">1 day ago</small>
                                            <p class="mb-0">আমি পানির পরীক্ষাটি করে দেখেছি, কাজ হয়েছে!</p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <!-- Sidebar -->
                        <div class="col-md-4">
                            <div class="sidebar-card mb-4 d-none d-sm-block">
                                <h6>Search Articles</h6>
                                <div class="search-box">
                                    <input type="text" placeholder="Cloth Gives You Confidence...">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </div>

                            <div class="recommend-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3"><i
                                            class="fas fa-check-circle text-second me-2"></i>Recommended Products</h5>
                                    @foreach ($r_products as $product)
                                        <div class="d-flex align-items-start mb-3">

                                            <img src="{{ $product->thum_image ? $softUrl . $product->thum_image : asset('assets/images/product_default.png') }}" alt="Mustard Honey" class="rounded me-3" width="60"
                                                height="60">
                                            <div>
                                                <small class="fw-bold">{{ $product->Product_Name }}</small><br>
                                                <a href="{{ route('get_product_detail', ['slug' => $product->slug]) }}" class="btn btn-outline-dark btn-sm mt-2 rounded-pill px-5">View Detail</a>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-center mt-3">
                                        <a href="{{ route('all.products') }}" class="btn btn-outline-warning rounded-pill px-5">View All Products</a>
                                    </div>
                                </div>
                            </div>

                            <div class="tag-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3">Popular Tags</h5>
                                    <div class="d-flex flex-wrap gap-2">
                                          <?php
    $tagsAr = explode(',', $blog->tags);
                                            ?>
                                            @foreach ($tagsAr as $tg)
                                                <span class="badge bg-light text-dark border">{{ trim($tg) }}</span>
                                            @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="subscribe-card">

                                <div class="subscribe-icon text-second">
                                    <i class="fa-solid fa-envelope"></i>
                                </div>
                                <h6 class="fw-bold">Get Fashion Updates</h6>
                                <p>Get the latest fashion trends, new arrivals, styling tips, and exclusive offers delivered straight to your inbox.</p>
                                <input type="email" placeholder="Your email address">
                                <button class="btn-subscribe">Subscribe</button>
                            </div>
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
 <!-- Footer Section -->
    <footer class="footer-section pt-5 pb-3">
        <div class="container">
            <div class="row gy-4">
                <!-- Contact -->
                <div class="col-lg-4 col-md-6 col-xs-12">
                    <h4 class="footer-title">Contact Info</h4>
                    <ul class="footer-contact list-unstyled">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                           {{ $setting->address }}
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:{{ $setting->email }}">
                                {{ $setting->email }}
                            </a>
                        </li>
                        <li>
                            <i class="bi bi-headset"></i>
                            Hotline: {{ $setting->hotline_number }}
                        </li>
                    </ul>

                    <div class="social-links mt-4">
                        <a href="{{ $setting->facebook_link }}" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="{{ $setting->instagrame_link }}" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="{{ $setting->youtube }}" target="_blank"><i class="bi bi-youtube"></i></a>
                        <a href="{{ $setting->tiktok }}" target="_blank" href=""><i class="bi bi-tiktok"></i></a>

                    </div>
                </div>
                <!-- Useful Links -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h4 class="footer-title">Quick Route</h4>

                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('all.products') }}">Products</a></li>
                        <li><a href="{{ route('galleries') }}">Galleries</a></li>
                        <li><a href="{{ route('get_all_blog') }}">Blogs</a></li>
                    </ul>
                </div>
                <!-- About -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h4 class="footer-title">Useful Links</h4>

                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ route('get_privecy_policy') }}">Privecy Policy</a></li>
                        <li><a href="{{ route('get_terms_condition') }}">Terms & Condition</a></li>
                        <li><a href="{{ route('get_return_policy') }}">Return Policy</a></li>
                        <li><a href="{{ route('get_delivery_policy') }}">Delivery Policy</a></li>
                    </ul>
                </div>
                <!-- Map -->
                <div class="col-lg-4 col-xs-12">
                    <iframe src="{{ $setting->google_map }}" width="100%" height="220" style="border:0;" 
                    allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="Store Map"></iframe>

                </div>
            </div>
            <hr class="footer-divider">
            <div class="row align-items-center mt-3">
                <div class="col-lg-6 col-12 mt-0">
                    <p class="mb-0">
                        © {{ $setting->Company_Name }}. All rights reserved.
                    </p>
                </div>
                <div class="col-lg-6 col-12  text-center text-md-end mt-2 mt-md-0">
                    Developed by
                    <a href="#" class="developer-link">Link Up Technology</a>
                </div>
            </div>
        </div>
    </footer>

 
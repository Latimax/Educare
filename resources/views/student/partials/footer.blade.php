<footer class="footer mt-30">
    <div class="container">
        <div class="row">
                      <!-- Footer Bottom -->
            <div class="col-lg-12">
                <div class="footer_bottm">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6">
                            <ul class="fotb_left d-flex align-items-center gap-2">
                                <li>
                                    <a href="{{ url('/') }}">
                                        <div class="footer_logo">
                                            <img src="{{ asset($imgpath . 'logo.png') }}" alt="site logo"
                                                class="light-logo">
                                            <img src="{{ asset($imgpath . 'white-logo.png') }}" alt="site logo"
                                                class="logo-inverse">
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <p class="mb-0">©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> <strong>{{ $schoolinfo->site_name }}</strong>. All
                                        Rights Reserved.
                                    </p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-0">Made by <a href="https://latimaxtech.com" class="text-primary-600">Latimax
                                    Tech</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Vertical Menu -->
<script src="{{ asset('studentpage/js/vertical-responsive-menu.min.js') }}"></script>
<!-- jQuery Library -->
<script src="{{ asset('studentpage/js/jquery-3.7.1.min.js') }}"></script>

<script src="{{ asset('studentpage/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('studentpage/vendor/OwlCarousel/owl.carousel.js') }}"></script>

<!-- Semantic UI -->
<script src="{{ asset('studentpage/vendor/semantic/semantic.min.js') }}"></script>

<!-- Bootstrap Select -->
<script src="{{ asset('studentpage/vendor/bootstrap-select/docs/docs/dist/js/bootstrap-select.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('studentpage/js/custom.js') }}"></script>

<!-- Night Mode Toggle -->
<script src="{{ asset('studentpage/js/night-mode.js') }}"></script>

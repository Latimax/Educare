<div class="footer-area">
    <div class="container">
        <div class="row">
            <!-- Left Section: Logo and Description -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-left">
                    <a href="{{ url('/') }}" class="logo">
                        <img src="{{ asset($imgpath . 'logo.png') }}" class="main-logo" alt="logo" />
                    </a>
                    <p>{{ $schoolinfo->meta_description ?? 'Welcome to our school.' }}</p>
                    <ul class="footer-social">
                        @if (!empty($schoolinfo->facebook))
                            <li><a href="{{ $schoolinfo->facebook }}" target="_blank"><i
                                        class="flaticon-facebook"></i></a></li>
                        @endif
                        @if (!empty($schoolinfo->email))
                            <li><a href="{{ url('contact') }}"><i class="flaticon-envelope"></i></a></li>
                        @endif
                        @if (!empty($schoolinfo->website))
                            <li><a href="{{ $schoolinfo->website }}" target="_blank"><i
                                        class="flaticon-google-plus"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- School Info Links -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-content fml-25">
                    <h2>{{ $schoolinfo->short_name ?? 'School' }}</h2>
                    <ul>
                        <li><a href="{{ url('contact') }}"><i class="flaticon-next"></i> Support</a></li>
                        <li><a href="{{ url('classes') }}"><i class="flaticon-next"></i> Career</a></li>
                        <li><a href="{{ url('teachers') }}"><i class="flaticon-next"></i> Teachers</a></li>
                        <li><a href="{{ url('teachers') }}"><i class="flaticon-next"></i> Staffs</a></li>
                        <li><a href="{{ url('contact') }}"><i class="flaticon-next"></i> Contact</a></li>
                    </ul>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <div class="footer-content fml-15">
                    <h2>Quick Links</h2>
                    <ul>
                        <li><a href="{{ url('/') }}"><i class="flaticon-next"></i> Home</a></li>
                        <li><a href="{{ url('classes') }}"><i class="flaticon-next"></i> Classes</a></li>
                        <li><a href="{{ url('contact') }}"><i class="flaticon-next"></i> Courses</a></li>
                        <li><a href="{{ url('contact') }}"><i class="flaticon-next"></i> Why Us?</a></li>
                        <li><a href="{{ url('faq') }}"><i class="flaticon-next"></i> FAQ</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-content fml-15 fml-20">
                    <h2>Find Us</h2>
                    <ul>
                        @if (!empty($schoolinfo->phone))
                            <li><a href="tel:{{ $schoolinfo->phone }}"><i class="flaticon-next"></i>
                                    {{ $schoolinfo->phone }}</a></li>
                        @endif
                        @if (!empty($schoolinfo->phone_alt))
                            <li><a href="tel:{{ $schoolinfo->phone_alt }}"><i class="flaticon-next"></i>
                                    {{ $schoolinfo->phone_alt }}</a></li>
                        @endif
                        @if (!empty($schoolinfo->email))
                            <li><a href="mailto:{{ $schoolinfo->email }}"><i class="flaticon-next"></i>
                                    {{ $schoolinfo->email }}</a></li>
                        @endif
                        @if (!empty($schoolinfo->whatsapp))
                            <li><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $schoolinfo->whatsapp) }}"
                                    target="_blank"><i class="flaticon-next"></i> WhatsApp</a></li>
                        @endif
                        @if (!empty($schoolinfo->address))
                            <li><a href="#"><i class="flaticon-next"></i>{{ $schoolinfo->city }}, {{ $schoolinfo->state }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Copy Area -->
<div class="copy-area">
    <div class="container">
        <div class="col-lg-12">
            <div class="row">
                <div class="copy">
                    <p> {{ date('Y') }} © <span>{{ $schoolinfo->short_name ?? 'School' }}</span> is Designed by
                        <a href="https://latimaxtech.com" class="link"> Latimax Tech</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

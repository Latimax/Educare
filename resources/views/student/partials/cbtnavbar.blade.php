<!-- Header Start -->
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="back_link">
                    @php
                                $student = Auth::guard('student')->user();
                            @endphp
                    <a href="#" class="hde151">{{ $student->firstname . " ". $student->lastname   }}</a>
                </div>
                <div class="ml_item">
                    <div class="timer" id="timer">
                        Time Remaining: <span id="time-remaining">{{ $remainingTime }}</span>
                    </div>


                </div>
                <div class="header_right pr-0">
                    <ul>
                        <li class="profile-dropdown">
                            @php
                                $student = Auth::guard('student')->user();
                            @endphp
                            <a href="#" class="opts_account" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false">
                                @if ($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Profile Photo"
                                        class="w-40-px h-40-px object-fit-cover rounded-circle">
                                @else
                                    <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="Default Avatar"
                                        class="w-40-px h-40-px object-fit-cover rounded-circle">
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown_account drop-down dropdown-menu-end">
                                <div class="channel_my">
                                    <div class="profile_link">
                                        @if ($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Profile Photo"
                                                class="w-40-px h-40-px object-fit-cover rounded-circle">
                                        @else
                                            <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="Default Avatar"
                                                class="w-40-px h-40-px object-fit-cover rounded-circle">
                                        @endif
                                        <div class="pd_content">
                                            <div class="rhte85">
                                                <h6>{{ $student->firstname }}</h6>
                                                <div class="mef78" title="Verify">
                                                    <i class='uil uil-check-circle'></i>
                                                </div>
                                            </div>
                                            <span>{{ $student->studentClass->class_name }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="night_mode_switch__btn">
                                    <a href="#" id="night-mode" class="btn-night-mode">
                                        <i class="uil uil-moon"></i> Night mode
                                        <span class="btn-night-mode-switch">
                                            <span class="uk-switch-button"></span>
                                        </span>
                                    </a>
                                </div>
                                <a href="{{ route('student.dashboard') }}" class="item channel_item">Calculator</a>
                                <a href="{{ route('student.auth.logout') }}" class="item channel_item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                    Out</a>
                                <form id="logout-form" action="{{ route('student.auth.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</header>

<div class="wrapper _bg4586 _new89">
    <div class="_215b15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title125 p-2 bg-transparent">
                        <div class="titleleft">
                            <div class="ttl121">
                                <h4> Subject: <span> {{ $subject->subject_name }} </span> </h4>
                            </div>
                        </div>
                        <div class="titleright">
                            <h4> Type: <span>
                                    @if ($type == 'ft')
                                        First Test
                                    @elseif ($type == 'st')
                                        Second Test
                                    @else
                                        Examination
                                    @endif
                                </span> </h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Header End -->

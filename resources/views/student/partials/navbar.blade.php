<!-- Header Start -->
<header class="header clearfix">
    <button type="button" id="toggleMenu" class="toggle_menu">
        <i class='uil uil-bars'></i>
    </button>
    <button id="collapse_menu" class="collapse_menu">
        <i class="uil uil-bars collapse_menu--icon"></i>
        <span class="collapse_menu--label"></span>
    </button>
    <div class="main_logo" id="logo">
        @php
            $imgpath = 'storage/front/images/';
        @endphp
        <a href="{{ route('student.dashboard') }}">
            <img src="{{ asset($imgpath . 'logo.png') }}" alt="site logo" width="150px" height="50px"
                class="light-logo">
            <img src="{{ asset($imgpath . 'white-logo.png') }}" alt="site logo" width="150px" height="50px"
                class="logo-inverse">
        </a>
    </div>
    <div class="search120">
        <div class="ui search">
            <div class="ui left icon input swdh10">
                <input class="prompt srch10" type="text" placeholder="Search for Tutorials, Tests, Resources...">
                <i class='uil uil-search-alt icon icon1'></i>
            </div>
        </div>
    </div>
    <div class="header_right">
        <ul>
            <li class="profile-dropdown">
                @php
                    $student = Auth::guard('student')->user();
                @endphp
                <a href="#" class="opts_account" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
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
                        <a href="{{ route('student.profile') }}" class="dp_link_12">View Profile</a>
                    </div>
                    <div class="night_mode_switch__btn">
                        <a href="#" id="night-mode" class="btn-night-mode">
                            <i class="uil uil-moon"></i> Night mode
                            <span class="btn-night-mode-switch">
                                <span class="uk-switch-button"></span>
                            </span>
                        </a>
                    </div>
                    <a href="{{ route('student.dashboard') }}" class="item channel_item">Dashboard</a>
                    <a href="{{ route('student.settings.account') }}" class="item channel_item">Settings</a>
                    <a href="{{ route('student.auth.logout') }}" class="item channel_item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                    <form id="logout-form" action="{{ route('student.auth.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</header>
<!-- Header End -->

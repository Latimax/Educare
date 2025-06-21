<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>

        <a href="{{ url('/') }}" class="sidebar-logo">
            @php
                $imgpath = 'storage/front/images/';
            @endphp

            <img src="{{ asset($imgpath . 'logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset($imgpath . 'white-logo.png') }}" alt="site logo" class="dark-logo">
            <link rel="icon" href="{{ asset($imgpath . 'favicon.png') }}">

        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li class="{{ request()->routeIs('parent.dashboard') ? 'active-page' : '' }}">
                <a href="{{ route('parent.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>

            </li>



            <li class = "{{ request()->routeIs('parent.children.*') ? 'active-page' : '' }}">
                <a href="{{ route('parent.children.index') }}" class="{{ request()->routeIs('parent.children.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Children</span>
                </a>
            </li>


            <li class="sidebar-menu-group-title">Application</li>



            <li class = "{{ request()->routeIs('parent.payments.*') ? 'active-page' : '' }}">
                <a href="{{ route('parent.payments.index') }}" class="{{ request()->routeIs('parent.payments.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Payments</span>
                </a>
            </li>

            @php
                // Check if the current route is one of the settings routes
                $settingsRoutes = ['parent.profile'];
                $isSettingsOpen = request()->routeIs($settingsRoutes);
            @endphp

            <li class="dropdown {{ $isSettingsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu {{ $isSettingsOpen ? 'show' : '' }}"
                    style="display: {{ $isSettingsOpen ? 'block' : 'none' }}">

                    <li class="{{ request()->routeIs('parent.profile') ? 'active active-page' : '' }}">
                        <a href="{{ route('parent.profile') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Profile</a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</aside>

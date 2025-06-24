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
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('staff.dashboard') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Overview</a>
                    </li>

                </ul>
            </li>

            @php
                // Check if the current route is one of the students routes
                $studentsRoutes = ['staff.students.*'];
                $isStudentsOpen = request()->routeIs($studentsRoutes);
            @endphp

            <li class="dropdown {{ $isStudentsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>Students</span>
                </a>
                <ul class="sidebar-submenu {{ $isStudentsOpen ? 'show' : '' }}"
                    style="display: {{ $isStudentsOpen ? 'block' : 'none' }}">

                    <li
                        class="{{ request()->routeIs('staff.students.index') || request()->routeIs('staff.students.edit') || request()->routeIs('staff.students.children') ? 'active active-page' : '' }}">
                        <a href="{{ route('staff.students.index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Students</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('staff.students.classes') || request()->routeIs('staff.students.classes.*') || request()->routeIs('staff.students.filter') ? 'active active-page' : '' }}">
                        <a href="{{ route('staff.students.classes.all') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i>Classes</a>
                    </li>

                </ul>
            </li>

            <li class="sidebar-menu-group-title">Examination</li>

            <li class = "{{ request()->routeIs('staff.examquestions.*') ? 'active-page' : '' }}">
                <a href="{{ route('staff.examquestions.index') }}" class="{{ request()->routeIs('staff.examquestions.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="healthicons:i-exam-multiple-choice-outline" class="menu-icon"></iconify-icon>
                    <span>Exam Questions</span>
                </a>
            </li>

            <li class = "{{ request()->routeIs('staff.cbtquestions.*') ? 'active-page' : '' }}">
                <a href="{{ route('staff.cbtquestions.index') }}" class="{{ request()->routeIs('staff.cbtquestions.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="qlementine-icons:computer-16" class="menu-icon"></iconify-icon>
                    <span>CBT Questions</span>
                </a>
            </li>

            <li class = "{{ request()->routeIs('staff.studentscores.*') ? 'active-page' : '' }}">
                <a href="{{ route('staff.studentscores.index') }}" class="{{ request()->routeIs('staff.studentscores.*') ? 'active-page' : '' }}  ">
                    <iconify-icon icon="carbon:result" class="menu-icon"></iconify-icon>
                    <span>Update Scores</span>
                </a>
            </li>


             <li class="sidebar-menu-group-title">Results</li>

            <li class = "{{ request()->routeIs('staff.studentresults.*') ? 'active-page' : '' }}">
                <a href="{{ route('staff.studentresults.index') }}" class="{{ request()->routeIs('staff.studentresults.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="fluent-mdl2:poll-results" class="menu-icon"></iconify-icon>
                    <span>Compute Result</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">Application</li>



            @php
                // Check if the current route is one of the settings routes
                $settingsRoutes = [ 'staff.profile'];
                $isSettingsOpen = request()->routeIs($settingsRoutes);
            @endphp

            <li class="dropdown {{ $isSettingsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu {{ $isSettingsOpen ? 'show' : '' }}"
                    style="display: {{ $isSettingsOpen ? 'block' : 'none' }}">

                    <li class="{{ request()->routeIs('staff.profile') ? 'active active-page' : '' }}">
                        <a href="{{ route('staff.profile') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Profile</a>
                    </li>

                </ul>
            </li>

        </ul>
    </div>
</aside>

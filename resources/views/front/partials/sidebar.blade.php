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
                        <a href="{{ route('admin.dashboard') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Overview</a>
                    </li>

                </ul>
            </li>
            {{-- <li class="sidebar-menu-group-title">Application</li>
        <li class="{{ request()->routeIs('admin.webhosting.*') ? 'active-page' : '' }}">
          <a href="{{ route('admin.webhosting.index') }}" class="{{ request()->routeIs('admin.webhosting.*') ? 'active-page' : '' }}">
            <iconify-icon icon="mage:globe" class="menu-icon"></iconify-icon>
            <span>Hosting Company</span>
          </a>
        </li>


        <li class="dropdown {{ request()->routeIs('admin.domain.*') || request()->routeIs('admin.cpanel.*') ? 'active-page dropdown-open' : '' }}">
          <a href="javascript:void(0)">
            <iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
            <span>Services</span>
          </a>
          <ul class="sidebar-submenu">
            <li class="{{ request()->routeIs('admin.domain.*') ? 'active-page' : '' }}">
              <a href="{{ route('admin.domain.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Domains</a>
            </li>
            <li class="{{ request()->routeIs('admin.cpanel.*') ? 'active-page' : '' }}">
              <a href="{{ route('admin.cpanel.index') }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> cPanel</a>
            </li>

          </ul>
        </li> --}}

            @php
                // Check if the current route is one of the students routes
                $studentsRoutes = ['admin.students.*'];
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
                        class="{{ request()->routeIs('admin.students.index') || request()->routeIs('admin.students.edit') || request()->routeIs('admin.students.children') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.students.index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Students</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('admin.students.classes') || request()->routeIs('admin.students.classes.*') || request()->routeIs('admin.students.filter') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.students.classes.all') }}"><i
                                class="ri-circle-fill circle-icon text-danger-600 w-auto"></i>Classes</a>
                    </li>
                    <li
                        class="{{ request()->routeIs('admin.students.levels.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.students.levels') }}"><i
                                class="ri-circle-fill circle-icon text-info-600 w-auto"></i> Sections</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.students.create') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.students.create') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Student</a>
                    </li>
                </ul>
            </li>

              <li class="{{ request()->routeIs('admin.parents.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.parents.index') }}" class="{{ request()->routeIs('admin.parents.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="raphael:parent" class="menu-icon"></iconify-icon>
                    <span>Parents</span>
                </a>
            </li>

            @php
                // Check if the current route is one of the staffs routes
                $staffsRoutes = ['admin.staffs.*'];
                $isStaffsOpen = request()->routeIs($staffsRoutes);
            @endphp
            <li class="dropdown {{ $isStaffsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="flowbite:users-outline" class="menu-icon"></iconify-icon>
                    <span>Staffs</span>
                </a>
                <ul class="sidebar-submenu {{ $isStaffsOpen ? 'show' : '' }}"
                    style="display: {{ $isStaffsOpen ? 'block' : 'none' }}">
                    <li
                        class="{{ request()->routeIs('admin.staffs.index') || request()->routeIs('admin.staffs.edit') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.staffs.index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Staffs</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.staffs.create') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.staffs.create') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Add New Staff</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-menu-group-title">Examination</li>

            <li class = "{{ request()->routeIs('admin.examquestions.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.examquestions.index') }}" class="{{ request()->routeIs('admin.examquestions.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="healthicons:i-exam-multiple-choice-outline" class="menu-icon"></iconify-icon>
                    <span>Exam Questions</span>
                </a>
            </li>

            <li class = "{{ request()->routeIs('admin.cbtquestions.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.cbtquestions.index') }}" class="{{ request()->routeIs('admin.cbtquestions.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="qlementine-icons:computer-16" class="menu-icon"></iconify-icon>
                    <span>CBT Questions</span>
                </a>
            </li>

            <li class = "{{ request()->routeIs('admin.studentscores.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.studentscores.index') }}" class="{{ request()->routeIs('admin.studentscores.*') ? 'active-page' : '' }}  ">
                    <iconify-icon icon="carbon:result" class="menu-icon"></iconify-icon>
                    <span>Test/Exam Scores</span>
                </a>
            </li>


             <li class="sidebar-menu-group-title">Results</li>

            <li class = "{{ request()->routeIs('admin.studentresults.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.studentresults.index') }}" class="{{ request()->routeIs('admin.studentresults.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="fluent-mdl2:poll-results" class="menu-icon"></iconify-icon>
                    <span>Compute Result</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">Application</li>

            <li class = "{{ request()->routeIs('admin.subjects.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.subjects.index') }}" class="{{ request()->routeIs('admin.subjects.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="material-symbols:book-5" class="menu-icon"></iconify-icon>
                    <span>Subjects</span>
                </a>
            </li>


            <li class = "{{ request()->routeIs('admin.payments.*') ? 'active-page' : '' }}">
                <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active-page' : '' }} ">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Payments</span>
                </a>
            </li>



             @php
                // Check if the current route is one of the exams config routes
                $examsConfigRoutes = ['admin.cbtconfig.*', 'admin.grades.*', 'admin.resultcomments.*'];
                $isExamsOpen = request()->routeIs($examsConfigRoutes);
            @endphp

            <li class="dropdown {{ $isExamsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="fluent:comment-16-regular" class="menu-icon"></iconify-icon>
                    <span>Exams Config</span>
                </a>
                <ul class="sidebar-submenu {{ $isExamsOpen ? 'show' : '' }}"
                    style="display: {{ $isExamsOpen ? 'block' : 'none' }}">


                    <li class="{{ request()->routeIs('admin.cbtconfig.index.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.cbtconfig.index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>Cbt Setup</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.grades.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.grades.index') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Grades</a>
                    </li>

                     <li class="{{ request()->routeIs('admin.resultcomments.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.resultcomments.index') }}"><i
                                class="ri-circle-fill circle-icon text-secondary-main w-auto"></i> Comments</a>
                    </li>
                </ul>
            </li>

            @php
                // Check if the current route is one of the settings routes
                $settingsRoutes = ['admin.school-info.*', 'admin.levels.*', 'admin.sessions.*', 'admin.classes.*', 'admin.advanced.*', 'admin.profile'];
                $isSettingsOpen = request()->routeIs($settingsRoutes);
            @endphp

            <li class="dropdown {{ $isSettingsOpen ? 'dropdown-open' : '' }}">
                <a href="javascript:void(0)">
                    <iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
                <ul class="sidebar-submenu {{ $isSettingsOpen ? 'show' : '' }}"
                    style="display: {{ $isSettingsOpen ? 'block' : 'none' }}">
                    <li class="{{ request()->routeIs('admin.levels.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.levels.index') }}"><i
                                class="ri-circle-fill circle-icon text-secondary-600 w-auto"></i> Levels</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.classes.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.classes.index') }}"><i
                                class="ri-circle-fill circle-icon text-secondary-600 w-auto"></i> Classes</a>
                    </li>

                     <li class="{{ request()->routeIs('admin.sessions.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.sessions.index') }}"><i
                                class="ri-circle-fill circle-icon text-secondary-600 w-auto"></i> Sessions</a>
                    </li>

                    <li class="{{ request()->routeIs('admin.school-info.*') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.school-info.index') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> School Info</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.profile') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.profile') }}"><i
                                class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Profile</a>
                    </li>
                     <li class="{{ request()->routeIs('admin.advanced.index') ? 'active active-page' : '' }}">
                        <a href="{{ route('admin.advanced.index') }}"><i
                                class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Advanced Setting</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>

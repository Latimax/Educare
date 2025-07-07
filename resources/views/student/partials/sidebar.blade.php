<nav class="vertical_nav">
    <div class="left_section menu_left" id="js-menu">
        <!-- Menu Toggle Button -->
        <button type="button" id="toggleMenu" class="toggle_menu">
            <i class='uil uil-bars'></i>
        </button>

        <!-- Main Menu -->
        <div class="left_section">
            <ul>
                <li class="menu--item">
                    <a href="{{ route('student.dashboard') }}" class="menu--link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" title="Dashboard">
                        <i class='uil uil-home-alt menu--icon'></i>
                        <span class="menu--label">Dashboard</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{ route('student.cbt.index') }}" class="menu--link {{ request()->routeIs('student.cbt.*') ? 'active' : '' }}" title="CBT">
                        <i class='uil uil-clipboard-alt menu--icon'></i>
                        <span class="menu--label">CBT</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{ route('student.results.index') }}" class="menu--link {{ request()->routeIs('student.results.*') ? 'active' : '' }}" title="My Results">
                        <i class='uil uil-chart-bar menu--icon'></i>
                        <span class="menu--label">My Results</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{ route('student.documents.index') }}" class="menu--link {{ request()->routeIs('student.documents.*') ? 'active' : '' }}" title="My Documents">
                        <i class='uil uil-file-alt menu--icon'></i>
                        <span class="menu--label">My Documents</span>
                    </a>
                </li>
                <li class="menu--item">
                    <a href="{{ route('student.profile') }}" class="menu--link {{ request()->routeIs('student.profile') ? 'active' : '' }}" title="Profile">
                        <i class='uil uil-user menu--icon'></i>
                        <span class="menu--label">Profile</span>
                    </a>
                </li>
                <li class="menu--item menu--item__has_sub_menu">
                    <label class="menu--link" title="Settings">
                        <i class='uil uil-cog menu--icon'></i>
                        <span class="menu--label">Settings</span>
                    </label>
                    <ul class="sub_menu">
                        <li class="sub_menu--item">
                            <a href="{{ route('student.settings.account') }}" class="sub_menu--link {{ request()->routeIs('student.settings.account') ? 'active' : '' }}">Account</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="{{ route('student.settings.notifications') }}" class="sub_menu--link {{ request()->routeIs('student.settings.notifications') ? 'active' : '' }}">Notifications</a>
                        </li>
                    </ul>
                </li>
                <li class="menu--item menu--item__has_sub_menu">
                    <label class="menu--link" title="Tools">
                        <i class='uil uil-wrench menu--icon'></i>
                        <span class="menu--label">Tools</span>
                    </label>
                    <ul class="sub_menu">
                        <li class="sub_menu--item">
                            <a href="{{ route('student.tools.calculator') }}" class="sub_menu--link {{ request()->routeIs('student.tools.calculator') ? 'active' : '' }}">Calculator</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="{{ route('student.tools.notes') }}" class="sub_menu--link {{ request()->routeIs('student.tools.notes') ? 'active' : '' }}">Notes</a>
                        </li>
                        <li class="sub_menu--item">
                            <a href="{{ route('student.tools.calendar') }}" class="sub_menu--link {{ request()->routeIs('student.tools.calendar') ? 'active' : '' }}">Calendar</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Support Section -->
        <div class="left_section pt-2">
            <ul>
                <li class="menu--item">
                    <a href="{{ route('student.help') }}" class="menu--link {{ request()->routeIs('student.help') ? 'active' : '' }}" title="Help">
                        <i class='uil uil-question-circle menu--icon'></i>
                        <span class="menu--label">Help</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

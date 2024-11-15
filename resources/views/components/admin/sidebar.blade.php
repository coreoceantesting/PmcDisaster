<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="22" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="17" />
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin/images/login-logo.png') }}" alt="" height="35" />
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin/images/logo.png') }}" alt="" height="50" />
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title">
                    <span data-key="t-menu">Menu</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}" >
                        <i class="ri-dashboard-2-line"></i>
                        <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li>

                @canany(['masters.all'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('departments.index') || request()->routeIs('lossTypes.index')  || request()->routeIs('complaintTypes.index') || request()->routeIs('complaintSubTypes.index')  ? 'active' : 'collapsed' }}" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                            <i class="ri-layout-3-line"></i>
                            <span data-key="t-layouts">Masters</span>
                        </a>
                        <div class="collapse menu-dropdown {{ request()->routeIs('departments.index') || request()->routeIs('lossTypes.index') || request()->routeIs('complaintTypes.index') || request()->routeIs('complaintSubTypes.index')  ? 'show' : '' }}" id="sidebarLayouts">
                            <ul class="nav nav-sm flex-column">
                                {{-- <li class="nav-item">
                                    <a href="{{ route('wards.index') }}" class="nav-link" data-key="t-horizontal">Wards</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.index') ? 'active' : '' }}" data-key="t-horizontal">Department</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('complaintTypes.index') }}" class="nav-link {{ request()->routeIs('complaintTypes.index') ? 'active' : '' }}" data-key="t-horizontal">Complaint Type</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('complaintSubTypes.index') }}" class="nav-link {{ request()->routeIs('complaintSubTypes.index') ? 'active' : '' }}" data-key="t-horizontal">Complaint Sub Type</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('lossTypes.index') }}" class="nav-link {{ request()->routeIs('lossTypes.index') ? 'active' : '' }}" data-key="t-horizontal">Loss Types</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan


                @canany(['users.view', 'roles.view'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('users.index') || request()->routeIs('roles.index') ? 'active' : 'collapsed' }}" href="#sidebarLayoutsone" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                        <i class="bx bx-user-circle"></i>
                        <span data-key="t-layouts">User Management</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('users.index') || request()->routeIs('roles.index') ? 'show' : '' }}" id="sidebarLayoutsone">
                        <ul class="nav nav-sm flex-column">
                            @can('users.view')
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" data-key="t-horizontal">Users</a>
                                </li>
                            @endcan
                            @can('roles.view')
                                <li class="nav-item">
                                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}" data-key="t-horizontal">Roles</a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcan

                @can(['complaints.create'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('complaints.create') ? 'active' : '' }}" href="{{ route('complaints.create') }}" >
                            <i class="ri-add-circle-fill"></i>
                            <span data-key="t-circle">Complaint Register </span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('complaints.index') ? 'active' : '' }}" href="{{ route('complaints.index') }}" >
                        <i class="ri-list-unordered"></i>
                        <span data-key="t-circle">Complaints List</span>
                    </a>
                </li>

                @can(['complaints.AcceptedList'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('accepetedComplaintList') ? 'active' : '' }}" href="{{ route('accepetedComplaintList') }}" >
                            <i class="ri-list-check-3"></i>
                            <span data-key="t-circle">Accepted Complaints List</span>
                        </a>
                    </li>
                @endcan

                @can(['complaints.ClosedList'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('closedComplaintList') ? 'active' : '' }}" href="{{ route('closedComplaintList') }}" >
                            <i class="ri-close-circle-fill"></i>
                            <span data-key="t-circle">Closed Complaints List</span>
                        </a>
                    </li>
                @endcan

                @can(['complaints.reports'])
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('departmentWiseReport') || request()->routeIs('dayWiseCallReport') ? 'active' : 'collapsed' }}" href="#sidebarLayoutstwo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                            <i class="ri-folder-chart-fill"></i>
                            <span data-key="t-layouts">Reports</span>
                        </a>
                        <div class="collapse menu-dropdown {{ request()->routeIs('departmentWiseReport') || request()->routeIs('dayWiseCallReport') ? 'show' : '' }}" id="sidebarLayoutstwo">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('departmentWiseReport') }}" class="nav-link {{ request()->routeIs('departmentWiseReport') ? 'active' : '' }}" data-key="t-horizontal">Department Wise Report</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dayWiseCallReport') }}" class="nav-link {{ request()->routeIs('dayWiseCallReport') ? 'active' : '' }}" data-key="t-horizontal">Day Wise Call Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>


<div class="vertical-overlay"></div>

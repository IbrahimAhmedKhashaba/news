<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    @can('search')
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
            action="{{ route('admin.search') }}" method="GET">
            @csrf
            <div class="input-group row">
                <input name="keyword" type="text" class="form-control bg-light border-0 small col-md-7"
                    placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="col-md-4">
                    <select name="option" id="" class="form-control bg-light border-0 small">
                        <optgroup label="Select Option" selected>
                            @can('users')
                                <option value="user">Users</option>
                            @endcan
                            @can('posts')
                                <option value="post">Posts</option>
                            @endcan
                            @can('categories')
                                <option value="category">Categories</option>
                            @endcan
                            @can('contacts')
                                <option value="contact">Contacts</option>
                            @endcan

                        </optgroup>
                    </select>
                </div>
                <div class="col-md-1">
                    <div class="input-group-append">
                        <button class="btn btn-primary mx-2" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endcan

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        @can('notifications')
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span id="count-notifications-admin"
                        class="badge badge-danger badge-counter">{{ auth()->guard('admin')->user()->unreadNotifications->count() }}</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifications
                    </h6>
                    <div class="" id="push-notifications-admin">
                        @forelse(auth()->guard('admin')->user()->unreadNotifications()->limit(5)->get() as $notify)
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ $notify->data['link'] }}?notify={{ $notify->id }}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $notify->created_at->diffForHumans() }}</div>
                                    <span class="font-weight-bold">{{ $notify->data['contact_title'] }}</span>
                                </div>
                            </a>
                        @empty
                            <p id="no-notifications" class="dropdown-item text-center small text-gray-500" href="#">No
                                New Notifications</p>
                        @endforelse
                    </div>
                    @if (auth()->guard('admin')->user()->unreadNotifications->count() > 5)
                        <a class="dropdown-item text-center small text-gray-500"
                            href="{{ route('admin.notifications.index') }}">Show All</a>
                    @endif
                </div>
            </li>
        @endcan

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">@if(strlen(auth()->user()->username) > 10){{ substr(auth()->user()->username, 0, 10)}}..@else {{ auth()->user()->username }} @endif</span>
                <img class="img-profile rounded-circle" src="{{ asset('assets/admin/img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @can('profile')
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                @endcan
                @can('settings')
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                @endcan
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

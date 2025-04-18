<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i>{{ $settings->email }}</p>
                    <p><i class="fas fa-phone-alt"></i>{{ $settings->phone }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu">
                    @if (auth()->check())
                        <a href="javascript:void(0)"
                            onclick="{document.getElementById('logoutForm').submit()}">Logout</a>Profile</a>Logout</a>
                    @else
                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('login') }}">Login</a>
                    @endif
                    <form id="logoutForm" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Start -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset( $settings->logo) }}" alt="Logo" />
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="b-ads">

                </div>
            </div>
            <div class="col-lg-3 col-md-4">
                <form action="{{ url('/search') }}" method="post">
                    @csrf
                    <div class="b-search">
                        <input name="search" type="text" placeholder="Search" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                    @error('search')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Brand End -->

<!-- Nav Bar Start -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">
                    <a href="{{ route('frontend.index') }}" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            @foreach ($categories as $category)
                                <a href="{{ route('frontend.category.posts', $category->slug) }}" class="dropdown-item"
                                    title="{{ $category->name }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('frontend.contact') }}" class="nav-item nav-link">Contact Us</a>
                    @if (auth()->check())
                        <a href="{{ route('frontend.dashboard.profile') }}" class="nav-item nav-link">Account</a>
                    @endif
                </div>
                <div class="social ml-auto">
                    @auth('web')
                        <!-- Notification Dropdown -->
                        <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span id="count-notifications"
                                class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                            style="width: 300px;">
                            <h6 class="dropdown-header">Notifications</h6>
                            <div id="push-notifications">
                                @if (auth()->user()->unreadNotifications->count() > 0)
                                    <div id="push-notificatioins">
                                        @foreach (auth()->user()->unreadNotifications()->take(5)->get() as $notify)
                                            <div
                                                class="dropdown-item d-flex justify-content-between align-items-center">
                                                <span>Post comment:
                                                    {{ substr($notify->data['post_title'], 0, 4) }}</span>
                                                <a href="{{  route('frontend.post.show' , $notify->data['post_slug']) }}?notify={{ $notify->id }}"
                                                    class="btn btn-sm btn-danger"><i class="fas fa-eye"></i></a>
                                            </div>
                                        @endforeach
                                        @if (auth()->user()->unreadNotifications->count() > 5)
                                            <div class="nav-link active text-center">
                                                <a class="btn w-100"
                                                    href="{{ route('frontend.dashboard.notifications') }}">view all</a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="dropdown-item text-center">No notifications</div>
                                @endif
                            </div>
                        </div>
                    @endauth
                <a href="{{ $settings->twitter }}" title="twitter" rel="nofollow"><i class="fab fa-twitter"></i></a>
                <a href="{{ $settings->facebook }}" title="facebook" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
                <a href="{{ $settings->instagram }}" title="instagram" rel="nofollow"><i class="fab fa-instagram"></i></a>
                <a href="{{ $settings->youtube }}" title="youtube" rel="nofollow"><i class="fab fa-youtube"></i></a>
            </div>
    </div>
    </nav>
</div>
</div>
<!-- Nav Bar End -->

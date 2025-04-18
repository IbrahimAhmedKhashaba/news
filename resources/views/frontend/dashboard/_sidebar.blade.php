<aside class="col-md-3 nav-sticky dashboard-sidebar">
    <!-- User Info Section -->
    <div class="user-info text-center p-3">
      <img
        src="{{ asset(auth()->user()->image) }}"
        alt="User Image"
        class="rounded-circle mb-2"
        style="width: 80px; height: 80px; object-fit: cover"
      />
      <h5 class="mb-0" style="color: #ff6f61">{{ auth()->user()->name }}</h5>
    </div>
<div class="list-group profile-sidebar-menu">
    <a href="{{ route('frontend.dashboard.profile') }}" class="list-group-item list-group-item-action menu-item {{ $profile_active ?? ''}}" data-section="profile">
        <i class="fas fa-user"></i> Profile
    </a>
    <a href="{{ route('frontend.dashboard.notifications') }}" class="list-group-item list-group-item-action menu-item {{ $notifications_active ?? ''}}"
        data-section="notifications">
        <i class="fas fa-bell"></i> Notifications
    </a>
    <a href="{{ route('frontend.dashboard.settings') }}" class="list-group-item list-group-item-action menu-item {{ $settings_active ?? ''}}" data-section="settings">
        <i class="fas fa-cog"></i> Settings
    </a>
    <a href="https://wa.me/+2{{ $settings->phone }}" class="list-group-item list-group-item-action menu-item" data-section="settings">
        <i class="fas fa-question" aria-hidden="true"></i> Support
    </a>
    <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit()" class="list-group-item list-group-item-action menu-item" data-section="settings">
        <i class="fas fa-power-off" aria-hidden="true"></i> Logout
    </a>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</div>
</aside>
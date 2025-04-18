
@include('layouts.frontend.header')
@include('layouts.frontend.navbar')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container">
      <ul class="breadcrumb">
        @yield('breadcrumb')
      </ul>
    </div>
  </div>
  <!-- Breadcrumb End -->
@yield('body')
@include('layouts.frontend.footer')

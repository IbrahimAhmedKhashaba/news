@include('layouts.dashboard.header')

<!-- Page Wrapper -->
<div id="wrapper">

    @include('layouts.dashboard.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            @include('layouts.dashboard.navbar')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('body')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        @include('layouts.dashboard.footer')
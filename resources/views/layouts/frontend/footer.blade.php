<!-- Footer Start -->
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Get in Touch</h3>
                    <div class="contact-info">
                        <p><i class="fa fa-map-marker"></i>{{ $settings->street }}, {{ $settings->city }},
                            {{ $settings->country }}</p>
                        <p class="overflow-hidden"><i class="fa fa-envelope"></i>{{ $settings->email }}</p>
                        <p><i class="fa fa-phone"></i>{{ $settings->phone }}</p>
                        <div class="social">
                            <a href="{{ $settings->twitter }}" title="twitter" rel="nofollow"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $settings->facebook }}" title="facebook" rel="nofollow"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $settings->instagram }}" title="instagram" rel="nofollow"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $settings->youtube }}" title="youtube" rel="nofollow"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Useful Links</h3>
                    <ul>
                        @foreach ($related_sites as $related_site)
                            <li><a href="{{ $related_site->url }}" target="_blank"
                                    title="{{ $related_site->name }}">{{ $related_site->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Categories</h3>
                    <ul>
                        @foreach($categories as $category)
                            
                        <li><a href="{{ route('frontend.category.posts' , $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="title">Newsletter</h3>
                    <div class="newsletter">
                        <p>
                            {{ $settings->small_desc }}
                        </p>
                        <form action="{{ route('frontend.news.subscriber') }}" method="POST">
                            @csrf
                            <input class="form-control" type="email" name='email' placeholder="Your email here" />
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Footer Menu Start -->
<div class="footer-menu">
    <div class="container">
        <div class="f-menu">
            <a href="{{ route('frontend.index') }}">Home</a>
            <a href="{{ route('frontend.contact') }}">Contact Us</a>
            @auth('web')
            <a href="{{ route('frontend.dashboard.profile') }}">Profile</a>
            <a href="{{ route('frontend.dashboard.settings') }}">Settings</a>
            <a href="{{ route('frontend.dashboard.notifications') }}">Notifications</a>
            @endauth
        </div>
    </div>
</div>
<!-- Footer Menu End -->

<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>
                    Copyright &copy; <a href="">{{ config('app.name') }}</a>. All Rights
                    Reserved
                </p>
            </div>

            <div class="col-md-6 template-by">
                <p>Designed By <a href="https://github.com/IbrahimAhmedKhashaba">{{ 'Ibrahim Kashaba' }}</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Footer Bottom End -->
@if(auth()->check())
<script>
    role = "user";
    id = "{{ auth()->user()->id }}";
    showPostRoute = "{{ route('frontend.post.show' , ':slug') }}";
    
</script>
@endif
<script src="{{ asset('build/assets/app-5a3c66fe.js') }}"></script>
<!-- Back to Top -->
<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/frontend/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('assets/frontend/lib/slick/slick.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('assets/frontend/js/main.js') }}"></script>
<script src="{{ asset('assets/vendor/file-input/js/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/vendor/file-input/themes/fa5/theme.min.js') }}"></script>
<script src="{{ asset('assets/vendor/summernote/summernote-bs4.min.js') }}"></script>
@stack('js')
</body>

</html>

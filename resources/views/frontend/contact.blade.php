@extends('layouts.frontend.app')
@section('meta_description')
    Contacts Page of News website
@endsection
@section('title')
    Contact-Us
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">Home</a></li>
<li class="breadcrumb-item active">Contact</li>
@endsection
@section('body')
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-8">
              <div class="contact-form">
                <form method="POST" action="{{ route('frontend.contact.store') }}">
                  @csrf
                    <div class="form-row">
                    <div class="form-group col-md-6">
                      <input
                      name="name"
                        type="text"
                        class="form-control"
                        placeholder="Your Name"
                      />
                      @error('name')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="form-group col-md-6">
                      <input
                      name="email"
                        type="email"
                        class="form-control"
                        placeholder="Your Email"
                      />
                      @error('email')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="form-group">
                    <input
                    name="phone"
                      type="text"
                      class="form-control"
                      placeholder="Phone Number"
                    />
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="form-group">
                    <input
                    name="title"
                      type="text"
                      class="form-control"
                      placeholder="Subject"
                    />
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="form-group">
                    <textarea
                    name="body"
                      class="form-control"
                      rows="5"
                      placeholder="Message"
                    ></textarea>
                    @error('body')
                        <span class="text-danger"><span class="text-danger">{{ $message }}</span></span>
                      @enderror
                  </div>
                  <div>
                    <button class="btn" type="submit">Send Message</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-4">
              <div class="contact-info">
                <h3>Get in Touch</h3>
                <p class="mb-4">
                  {{ $settings->small_desc }}
                </p>
                <h4><i class="fa fa-map-marker"></i>{{ $settings->street }}, {{ $settings->city }}, {{ $settings->country }}</h4>
                <h4><i class="fa fa-envelope"></i>{{ $settings->email }}</h4>
                <h4><i class="fa fa-phone"></i>{{ $settings->phone }}</h4>
                <div class="social">
                  <a title="twitter" href="{{ $settings->twitter }}"><i class="fab fa-twitter"></i></a>
                  <a title="facebook" href="{{ $settings->facebook }}"><i class="fab fa-facebook-f"></i></a>
                  <a title="linkedin" href="{{ $settings->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                  <a title="instagram" href="{{ $settings->instagram }}"><i class="fab fa-instagram"></i></a>
                  <a title="youtube" href="{{ $settings->youtube }}"><i class="fab fa-youtube"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Contact End -->
@endsection

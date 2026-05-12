@extends('home.home_master')

@section('home')

  <div class="breadcrumb-wrapper light-bg">
    <div class="container">
      @php
        $teams = App\Models\Team::get();
      @endphp
      <div class="breadcrumb-content">
        <h1 class="breadcrumb-title pb-0">Our Team</h1>
        <div class="breadcrumb-menu-wrapper">
          <div class="breadcrumb-menu-wrap">
            <div class="breadcrumb-menu">
              <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><img src="{{ asset('frontend/assets/images/blog/right-arrow.svg') }}" alt="right-arrow"></li>
                <li aria-current="page">Our Team</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- End breadcrumb -->

  <section class="lonyo-section-padding9">
    <div class="container">
      <div class="lonyo-section-title max-w616">
        <h2>Meet our brilliant team members</h2>
      </div>
      <div class="row">

        @foreach ($teams as $team)
        <div class="col-lg-3 col-md-6">
          <div class="lonyo-team-wrap" data-aos="fade-up" data-aos-duration="500">
            <div class="lonyo-team-thumb">
              <a href="single-team.html"><img src="{{ asset($team->image) }}" alt=""></a>
            </div>
            <div class="lonyo-team-content2">
              <a href="single-team.html">
                <h6>{{ $team->name }}</h6>
              </a>
              <p>{{ $team->position }}</p>
              <p>{{ $team->email }}</p>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="mt-50 team-btn" data-aos="fade-up" data-aos-duration="700">
        <a href="contact-us.html" class="lonyo-default-btn team-btn2">Would you joint of our group?</a>
      </div>
    </div>
  </section>
  <!-- end content -->

  <div class="lonyo-content-shape">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
  </div>
  @include('home.homelayout.apps')

@endsection
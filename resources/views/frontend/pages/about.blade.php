@extends('layouts.app')

@section('title', 'About Us | FutureMap Media')

@section("header")
@include("frontend.partials.page-header")
@endsection

@section('content')

@include("frontend.partials.banner",["header"=>"About Us"])

<section class="content-inner-2">
    <div class="container">

        <div class="row align-items-center about-bx1">

            {{-- About Image --}}
            <div class="col-lg-6 m-lg-b30">

                <div class="dz-media">

                    <img src="{{ asset("frontend/images/about/about-us.png") }}"
                         alt="FutureMap Media Concepts Limited"
                         class="aos-item">

                    <div class="year-exp aos-item">

                        <h2 class="year text-primary">3</h2>

                        <h4 class="text">
                            Core Areas<br>
                            of Excellence
                        </h4>

                    </div>

                </div>

            </div>

            {{-- About Content --}}
            <div class="col-lg-6 aos-item">

                <div class="section-head style-1">

                    <h6 class="text-primary sub-title">
                        Welcome to FutureMap Media
                    </h6>

                    <h2 class="title">
                        Building Human Capital and Creating Market Fields
                    </h2>

                </div>

                <p>
                    FutureMap Media Concepts Limited is a Nigerian media
                    organization committed to delivering credible, innovative
                    and world-class services. Since its registration in 2021,
                    the company has continued to provide solutions that empower
                    individuals, strengthen businesses and create sustainable
                    opportunities.
                </p>

                <p>
                    Our operations are built around three strategic areas:
                    media, e-commerce and educational services. Through
                    professionalism, innovation, integrity and reliable customer
                    service, we help our clients communicate effectively, expand
                    their markets and develop the knowledge and skills needed
                    for long-term success.
                </p>

                <div class="row">

                    <div class="col-md-6">

                        <div class="about-text-bx">

                            <h4>Our Mission</h4>

                            <p>
                                To build human capital, support wealth creation
                                and promote excellent leadership through meaningful
                                engagement and strategic partnerships.
                            </p>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="about-text-bx">

                            <h4>Our Vision</h4>

                            <p>
                                To become a leading global player in transformational
                                leadership, education and wealth creation, serving
                                local and international clients with excellence.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- <a href="{{ route('about') }}"
                   class="btn shadow-primary btn-primary">
                    Discover Our Story
                </a> --}}

            </div>

        </div>

    </div>
</section>

@if(isset($teamMembers) && $teamMembers->isNotEmpty())
    <section class="content-inner section-title">
        <div class="container">
<div class="section-head style-1 text-start mx-auto" style="max-width:900px;">
    <h6 class="text-primary sub-title">
        Leadership Team
    </h6>

    <h2 class="title">
        Meet Our Top Management Team
    </h2>

    <p class="m-t20">
        Headed by a skilled and passionate media and educational entrepreneur,
        our staff is made up of men and women of proven experience in the fields
        of Education, Media, and Information and Communication Technology (ICT),
        with excellent records in business and corporate management.
    </p>

    <p class="m-b0">
        The company has a total of <strong>14 permanent staff</strong> and
        <strong>6 contract staff</strong>.
    </p>
</div>

            <div class="row">
                <div class="col-lg-12 m-b30">

                    <div class="swiper-container team-swiper">
                        <div class="swiper-wrapper">

                            @foreach($teamMembers as $key => $teamMember)
                                {{-- @php
                                    $delay = 200 + (($key % 4) * 200);

                                    $profileUrl = Route::has('team.show')
                                        ? route('team.show', $teamMember->slug)
                                        : 'javascript:void(0);';
                                @endphp --}}

                                @php
                                $delay = 200 + (($loop->index % 4) * 200);

                                $profileUrl = route('team.member.show', $teamMember);
                                @endphp

                                <div class="swiper-slide">
                                    <div class="dz-team style-1 text-center m-b30 overlay-shine aos-item">

                                        <div class="dz-media">

                                            <a href="{{ $profileUrl }}">
                                                <img src="{{ $teamMember->image_url }}"
                                                     alt="{{ $teamMember->full_name }}"
                                                     loading="lazy">
                                            </a>

                                            @if(
                                                $teamMember->facebook ||
                                                $teamMember->instagram ||
                                                $teamMember->twitter ||
                                                $teamMember->linkedin
                                            )
                                                <ul class="team-social">

                                                    @if($teamMember->facebook)
                                                        <li>
                                                            <a href="{{ $teamMember->facebook }}"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               aria-label="Facebook profile">

                                                                <i class="fab fa-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($teamMember->instagram)
                                                        <li>
                                                            <a href="{{ $teamMember->instagram }}"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               aria-label="Instagram profile">

                                                                <i class="fab fa-instagram"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($teamMember->twitter)
                                                        <li>
                                                            <a href="{{ $teamMember->twitter }}"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               aria-label="Twitter profile">

                                                                <i class="fab fa-twitter"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($teamMember->linkedin)
                                                        <li>
                                                            <a href="{{ $teamMember->linkedin }}"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               aria-label="LinkedIn profile">

                                                                <i class="fab fa-linkedin-in"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            @endif

                                        </div>

                                        <div class="dz-content">

                                            <h5 class="dz-name">
                                                <a href="{{ $profileUrl }}">
                                                    {{ $teamMember->full_name }}
                                                </a>
                                            </h5>

                                            <h6 class="dz-position text-primary">
                                                {{ $teamMember->position }}
                                            </h6>

                                            @if($teamMember->department)
                                                <small class="text-muted">
                                                    {{ $teamMember->department }}
                                                </small>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        <div class="swiper-pagination2 text-center"></div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endif

{{-- Partners Section --}}
<section class="content-inner bg-gray partners-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 m-b30">

                <div class="partners-content">
                    <div class="section-head style-1 m-b20">

                        <h6 class="text-primary sub-title">
                            Strategic Collaboration
                        </h6>

                        <h2 class="title">
                            Our Partners
                        </h2>

                    </div>

                    <p>
                        We are currently connecting, networking, and partnering with
                        small, medium-sized, and multinational corporations. These
                        organisations include Think Counseling Network and Human
                        Development Initiative, Abuja; Gregory University, Abia State;
                        Cavendish University, Uganda; Godfather Productions, Abuja;
                        and Reallog Media International Limited, Abuja.
                    </p>

                    <p class="m-b0">
                        As a company with a strong focus on human capital investment,
                        we understand the importance of strategic alliances. We are
                        therefore open to productive partnerships and synergies that
                        will help us actualise our corporate vision and mission while
                        providing satisfactory services and products to our clients.
                    </p>
                </div>

            </div>

            <div class="col-lg-6 m-b30"
                >

                <div class="partners-image">

                    {{-- <img
                        src="{{ asset("frontend/images/partner.jpg") }}"
                        alt="FMAP Media partners"
                        loading="lazy"
                    > --}}

                    <div class="partners-shape">
                        <img
                            src="{{ asset("frontend/images/partner.jpg") }}"
                            alt=""
                            aria-hidden="true"
                        >
                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

@endsection


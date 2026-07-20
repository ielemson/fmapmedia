<div class="silder-two">
    <div class="swiper-container pagination-style1 main-silder-swiper">
        <div class="swiper-wrapper">

            {{-- Slide 1 --}}
            <div class="swiper-slide">
                <div class="dz-slide-item">
                    <div class="silder-content" data-swiper-parallax="-40%">
                        <div class="inner-content">
                            <h1 class="title">
                                Building Human Capitals, 
                                <span class="text-primary">Creating Market Fields</span>
                            </h1>

                            <p class="m-b30">
                                FutureMap Media Concepts Limited empowers individuals, businesses and institutions
                                through media, publishing, education, business promotion and strategic communication.
                            </p>

                            <a href="{{ url('about') }}" class="btn shadow-primary m-r30 btn-primary">
                                Explore FutureMap
                            </a>

                            <a href="{{ route('magazines.index') }}" class="btn btn-outline-primary shadow-none">
                                Browse Magazines
                            </a>
                        </div>
                    </div>

                    <div class="slider-img video-bx style-1" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
                        <img src="{{ asset('frontend/images/main-slider/slider-1.jpg') }}" alt="FutureMap Media">
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="swiper-slide">
                <div class="dz-slide-item">
                    <div class="silder-content" data-swiper-parallax="-40%">
                        <div class="inner-content">
                            <h1 class="title">
                                Discover Premium 
                                <span class="text-primary">Magazines & Publications</span>
                            </h1>

                            <p class="m-b30">
                                Access quality magazines, publications, reports and editorial content designed to
                                inform, educate, inspire and connect readers with new opportunities.
                            </p>

                            <a href="{{ route('magazines.index') }}" class="btn shadow-primary m-r30 btn-primary">
                                View Magazines
                            </a>

                            <a href="{{ url('contact') }}" class="btn btn-outline-primary shadow-none">
                                Contact Us
                            </a>
                        </div>
                    </div>

                    <div class="slider-img video-bx style-1" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
                        <img src="{{ asset('frontend/images/main-slider/slider-2.jpg') }}" alt="FutureMap Magazines">
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="swiper-slide">
                <div class="dz-slide-item">
                    <div class="silder-content" data-swiper-parallax="-40%">
                        <div class="inner-content">
                            <h1 class="title">
                                Become a FutureMap 
                                <span class="text-primary">Vendor Partner</span>
                            </h1>

                            <p class="m-b30">
                                Register as a vendor, receive your unique referral code, promote FutureMap magazines
                                and earn commission from successful magazine sales.
                            </p>

                            <a href="{{ route("vendor.register") }}" class="btn shadow-primary m-r30 btn-primary">
                                Become a Vendor
                            </a>

                            <a href="{{ route('magazines.index') }}" class="btn btn-outline-primary shadow-none">
                                Our Magazine
                            </a>
                        </div>
                    </div>

                    <div class="slider-img video-bx style-1" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
                        <img src="{{ asset('frontend/images/main-slider/slider-3.jpg') }}" alt="FutureMap Vendor Partner">
                    </div>
                </div>
            </div>

        </div>

        <div class="slider-two-pagination">
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
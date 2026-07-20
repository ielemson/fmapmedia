<section class="content-inner-2 bg-gray"
    style="background-image:url('{{ asset('frontend/images/background/pattern3.png') }}')">

    <div class="container">

        <div class="section-head style-2 text-center">
            <h6 class="text-primary sub-title">What We Provide</h6>
            <h2 class="title">Creating Platforms for Growth, Visibility and Opportunity</h2>
        </div>

        <div class="row m-b50 m-md-b10">

            <!-- Talent Harnessing -->
            <div class="col-lg-4 col-md-6">
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Talent Harnessing</h4>
                        <p>
                            We identify, develop and promote talents through structured media,
                            education and exposure-driven platforms.
                        </p>
                        <a href="{{ route('about') }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Media Exposure -->
            <div class="col-lg-4 col-md-6" >
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Media Exposure</h4>
                        <p>
                            We provide visibility for individuals, institutions and businesses
                            through professional media coverage and storytelling.
                        </p>
                        <a href="{{ route('services.show', ['service' => 'media-exposure']) }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Marketing Platforms -->
            <div class="col-lg-4 col-md-6">
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Marketing Platforms</h4>
                        <p>
                            We create channels that connect brands, products, services and
                            publications to wider market audiences.
                        </p>
                        <a href="{{ route('frontend.project') }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Educational Programmes -->
            <div class="col-lg-4 col-md-6">
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Educational Programmes</h4>
                        <p>
                            We support human capital development through training, learning
                            resources, seminars and educational consultancy.
                        </p>
                        <a href="{{ route("services.show", ["service" => "educational-services"]) }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Magazine Publishing -->
            <div class="col-lg-4 col-md-6">
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Magazine Publishing</h4>
                        <p>
                            We publish and distribute magazines, reports and knowledge products
                            for readers, partners and institutions.
                        </p>
                        <a href="{{ route('magazines.index') }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Strategic Partnerships -->
            <div class="col-lg-4 col-md-6">
                <div class="icon-bx-wraper style-3 left m-b50">
                    <div class="icon-bx-sm text-primary radius shadow icon-bx">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <div class="icon-content">
                        <h4 class="title m-b10">Strategic Partnerships</h4>
                        <p>
                            We build partnerships that help organizations expand visibility,
                            strengthen impact and reach new markets.
                        </p>
                        <a href="{{ route('contact') }}" class="btn-link">
                            Read More <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
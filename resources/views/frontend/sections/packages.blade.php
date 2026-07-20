{{-- PR Packages Section --}}
<section
    class="content-inner bg-gray pr-package-section"
    style="background-image: url('{{ asset('frontend/images/background/pattern3.png') }}');"
>
    <div class="container">
        <div class="row align-items-center g-5">

            {{-- Left: PR Package Image --}}
            <div
                class="col-xl-6 col-lg-6"
             
            >
                <div class="pr-package-image">
                    <img
                        src="{{ asset("frontend/images/packages.jpg") }}"
                        class="img-fluid w-100"
                        alt="FutureMap Media Public Relations Packages"
                        loading="lazy"
                    >
                </div>
            </div>

            {{-- Right: Package Write-up --}}
            <div
                class="col-xl-6 col-lg-6"
            
            >
                <div class="pr-package-content">

                    <div class="section-head style-2">
                        <h6 class="text-primary sub-title">
                            Public Relations Solutions
                        </h6>

                        <h2 class="title">
                            Our PR Packages
                        </h2>

                        <div class="dz-separator style-1 text-primary"></div>
                    </div>

                    <div class="pr-package-description">

                        <p>
                            Our value proposition focuses on helping businesses,
                            institutions and organisations position themselves
                            effectively and attract the attention of their target
                            audiences.
                        </p>

                        <p>
                            We develop practical public relations and promotional
                            solutions that strengthen brand visibility, improve market
                            presence and support business growth.
                        </p>

                        <p>
                            Our packages combine social media management, promotional
                            material design, website development, advertising and media
                            exposure. Each package is structured to meet different
                            publicity requirements and budgets.
                        </p>

                        <p>
                            By partnering with FutureMap Media, clients receive
                            professional support, creative strategies and the resources
                            required to communicate their value and compete effectively
                            in the marketplace.
                        </p>

                    </div>

               

                    {{-- Action Buttons --}}
                    <div class="package-actions mt-4">

                        <a
                            href="{{ route('contact') }}"
                            class="btn btn-primary me-2 mb-2"
                        >
                            Request a PR Package
                        </a>

                        <a
                            href="https://wa.me/2348035082149?text={{ urlencode('Hello FutureMap Media, I would like to enquire about your PR packages.') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-success mb-2"
                        >
                            <i class="fab fa-whatsapp me-2"></i>
                            Chat on WhatsApp
                        </a>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
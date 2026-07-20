<!-- Contact Sidebar -->
<div class="contact-sidebar">
    <div class="contact-box">

        <!-- Logo -->
        <div class="logo-contact logo-dark text-center mb-4">
            <a href="{{ route('index') }}">
                <img
                    src="{{ setting_asset(
                        setting('logo'),
                        'frontend/assets/images/logo.png'
                    ) }}"
                    alt="{{ setting('site_name', 'FutureMap Media') }}"
                >
            </a>
        </div>

        <!-- About -->
        <div class="m-b40 contact-text">
            <div class="dz-title">
                <h4>About {{ setting('site_name', 'FutureMap Media') }}</h4>
                <div class="dz-separator style-1 text-primary mb-3"></div>
            </div>

         <p>
    {{ setting(
        'sidebar_about',
        'Building Human Capitals, Creating Market Fields through media, publishing, education and business innovation.'
    ) }}
</p>

            <a href="{{ route('about') }}" class="btn btn-primary btn-sm">
                Learn More
            </a>
        </div>

        <!-- Contact Information -->
        <div class="dz-title">
            <h4>Contact Information</h4>
            <div class="dz-separator style-1 text-primary mb-3"></div>
        </div>

        <!-- Phone -->
        @php
            $primaryPhone = setting('phone', '08035082149');
            $secondaryPhone = setting('phone_two', '07062990717');

            $primaryPhoneLink = preg_replace('/[^0-9+]/', '', $primaryPhone);
            $secondaryPhoneLink = preg_replace('/[^0-9+]/', '', $secondaryPhone);
        @endphp

        @if ($primaryPhone || $secondaryPhone)
            <div class="icon-bx-wraper left m-b25">
                <div class="icon-md m-r20">
                    <span class="icon-cell">
                        <i class="las la-phone-volume"></i>
                    </span>
                </div>

                <div class="icon-content">
                    <h5>Call Us</h5>

                    <p class="mb-0">
                        @if ($primaryPhone)
                            <a href="tel:{{ $primaryPhoneLink }}">
                                {{ $primaryPhone }}
                            </a>
                        @endif

                        @if ($primaryPhone && $secondaryPhone)
                            <br>
                        @endif

                        @if ($secondaryPhone)
                            <a href="tel:{{ $secondaryPhoneLink }}">
                                {{ $secondaryPhone }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        @endif

        <!-- Email -->
        @php
            $primaryEmail = setting('email', 'info@fmapmedia.com');
            $secondaryEmail = setting('email_two', 'fmap-abuja@fmapmedia.com');
        @endphp

        @if ($primaryEmail || $secondaryEmail)
            <div class="icon-bx-wraper left m-b25">
                <div class="icon-md m-r20">
                    <span class="icon-cell">
                        <i class="las la-envelope-open"></i>
                    </span>
                </div>

                <div class="icon-content">
                    <h5>Email Us</h5>

                    <p class="mb-0">
                        @if ($primaryEmail)
                            <a href="mailto:{{ $primaryEmail }}">
                                {{ $primaryEmail }}
                            </a>
                        @endif

                        @if ($primaryEmail && $secondaryEmail)
                            <br>
                        @endif

                        @if ($secondaryEmail)
                            <a href="mailto:{{ $secondaryEmail }}">
                                {{ $secondaryEmail }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        @endif

        <!-- Address -->
        @if (setting('address'))
            <div class="icon-bx-wraper left m-b30">
                <div class="icon-md m-r20">
                    <span class="icon-cell">
                        <i class="las la-map-marker"></i>
                    </span>
                </div>

                <div class="icon-content">
                    <h5>Head Office</h5>

                    <p class="mb-0">
                        {!! nl2br(e(setting(
                            'address',
                            'Suite B11(4), Real Tower Centre, No. 26 A.E. Ekukinam Street, Utako District, Abuja, Nigeria.'
                        ))) !!}
                    </p>
                </div>
            </div>
        @endif

        <!-- Quick Links -->
        <div class="dz-title">
            <h4>Quick Links</h4>
            <div class="dz-separator style-1 text-primary mb-3"></div>
        </div>

        <ul class="list-check primary">
            <li>
                <a href="{{ route('magazines.index') }}">
                    Browse Magazines
                </a>
            </li>

            <li>
                <a href="{{ route('news.index') }}">
                    Latest News
                </a>
            </li>

            <li>
                <a href="{{ route('services.index') }}">
                    Our Services
                </a>
            </li>

            <li>
                <a href="{{ route('contact') }}">
                    Contact Us
                </a>
            </li>
        </ul>

        <!-- Social Media -->
        @if (
            setting('facebook') ||
            setting('instagram') ||
            setting('twitter') ||
            setting('youtube')
        )
            <div class="dz-title mt-4">
                <h4>Follow Us</h4>
                <div class="dz-separator style-1 text-primary mb-3"></div>
            </div>

            <ul class="dz-social-icon style-1">
                @if (setting('facebook'))
                    <li>
                        <a
                            href="{{ setting('facebook') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"
                        >
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                @endif

                @if (setting('instagram'))
                    <li>
                        <a
                            href="{{ setting('instagram') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"
                        >
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                @endif

                @if (setting('twitter'))
                    <li>
                        <a
                            href="{{ setting('twitter') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Twitter"
                        >
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                @endif

                @if (setting('youtube'))
                    <li>
                        <a
                            href="{{ setting('youtube') }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="YouTube"
                        >
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                @endif
            </ul>
        @endif

        <!-- CTA -->
        <div class="text-center mt-4">
            @auth
                @if (auth()->user()->hasRole('Vendor'))
                    <a href="{{ route('vendor.dashboard') }}"
                       class="btn btn-primary w-100">
                        Vendor Dashboard
                    </a>
                @else
                    <a href="{{ route('vendor.register') }}"
                       class="btn btn-primary w-100">
                        Become a Vendor
                    </a>
                @endif
            @else
                <a href="{{ route('vendor.register') }}"
                   class="btn btn-primary w-100">
                    Become a Vendor
                </a>
            @endauth
        </div>

    </div>
</div>

<div class="menu-close"></div>
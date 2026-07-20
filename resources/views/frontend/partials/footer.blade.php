<footer class="site-footer style-2" id="footer"
    style="background-image:url('{{ asset('frontend/images/background/pattern3.png') }}')">

    <div class="footer-top">
        <div class="container">

            <div class="row justify-content-center">

                {{-- About --}}
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget widget_about">

                        <div class="widget-title">
                            <h4 class="title">About {{ setting('site_name', 'FutureMap Media') }}</h4>
                        </div>

                        @if(setting('footer_about'))
                            <p>{{ setting('footer_about') }}</p>
                        @else
                            <p>
                                {{ \Illuminate\Support\Str::limit(setting('sidebar_about',
                                'FutureMap Media Concepts Limited is a leading media, publishing and educational organisation committed to building human capital and creating market opportunities.'),180) }}
                            </p>
                        @endif

                        <ul class="social-list style-2">

                            @if(setting('facebook'))
                                <li>
                                    <a href="{{ setting('facebook') }}" target="_blank">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                            @endif

                            @if(setting('instagram'))
                                <li>
                                    <a href="{{ setting('instagram') }}" target="_blank">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            @endif

                            @if(setting('twitter'))
                                <li>
                                    <a href="{{ setting('twitter') }}" target="_blank">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                            @endif

                            @if(setting('linkedin'))
                                <li>
                                    <a href="{{ setting('linkedin') }}" target="_blank">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            @endif

                            @if(setting('youtube'))
                                <li>
                                    <a href="{{ setting('youtube') }}" target="_blank">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            @endif

                        </ul>

                    </div>
                </div>

                {{-- Company --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="widget widget_categories p-lg-start">

                        <div class="widget-title">
                            <h4 class="title">Company</h4>
                        </div>

                        <ul>
                            <li class="cat-item">
                                <a href="{{ route('about') }}">About Us</a>
                            </li>

                            <li class="cat-item">
                                <a href="javascript:void(0)">Our Team</a>
                            </li>

                            <li class="cat-item">
                                <a href="{{ route('frontend.project') }}">Projects</a>
                            </li>

                            <li class="cat-item">
                                <a href="{{ route('contact') }}">Contact Us</a>
                            </li>
                        </ul>

                    </div>
                </div>

                {{-- Resources --}}
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="widget widget_categories">

                        <div class="widget-title">
                            <h4 class="title">Resources</h4>
                        </div>

                        <ul>

                            <li class="cat-item">
                                <a href="{{ route('index') }}">Home</a>
                            </li>

                            <li class="cat-item">
                                <a href="{{ route('magazines.index') }}">Magazine</a>
                            </li>

                            <li class="cat-item">
                                <a href="{{ route('news.index') }}">News</a>
                            </li>

                            <li class="cat-item">
                                @auth
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}">My Account</a>
                                @endauth
                            </li>

                        </ul>

                    </div>
                </div>

                {{-- Contact --}}
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">

                        <div class="widget-title">
                            <h4 class="title">Official Info</h4>
                        </div>

                        @if(setting('address'))
                            <p>
                                <strong>Address:</strong><br>
                                {!! nl2br(e(setting('address'))) !!}
                            </p>
                        @endif

                        @if(setting('email'))
                            <p>
                                <strong>Email:</strong><br>

                                <a href="mailto:{{ setting('email') }}">
                                    {{ setting('email') }}
                                </a>
                            </p>
                        @endif

                        @if(setting('phone'))
                            <p>
                                <strong>Phone:</strong><br>

                                <a href="tel:{{ preg_replace('/\s+/','',setting('phone')) }}">
                                    {{ setting('phone') }}
                                </a>
                            </p>
                        @endif

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">

            <div class="row align-items-center fb-inner spno">

                <div class="col-lg-6 col-md-12 text-start">

                    <span class="copyright-text">
                        © <span class="current-year"></span>

                        <a href="{{ route('index') }}" class="text-primary">
                            {{ setting('site_name', 'FutureMap Media') }}
                        </a>.

                        {{ setting('footer_copyright', 'All Rights Reserved.') }}
                    </span>

                </div>

                <div class="col-lg-6 col-md-12 text-end">

                    <ul class="footer-link d-inline-block">

                        @if(setting('privacy_policy_url'))
                            <li>
                                <a href="{{ setting('privacy_policy_url') }}">
                                    Privacy Policy
                                </a>
                            </li>
                        @endif

                        @if(setting('terms_url'))
                            <li>
                                <a href="{{ setting('terms_url') }}">
                                    Terms &amp; Conditions
                                </a>
                            </li>
                        @endif

                    </ul>

                </div>

            </div>

        </div>
    </div>

</footer>
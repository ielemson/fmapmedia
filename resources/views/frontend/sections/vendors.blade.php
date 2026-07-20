@if(isset($teamMembers) && $teamMembers->isNotEmpty())
    <section class="content-inner section-title">
        <div class="container">

            <div class="section-head style-1 text-center">
                <h6 class="text-primary sub-title">
                    Our Team
                </h6>

                <h2 class="title">
                    Our Creative Expertise
                </h2>
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
                                    <div class="dz-team style-1 text-center m-b30 overlay-shine aos-item"
                                         data-aos="fade-up"
                                         data-aos-duration="1500"
                                         data-aos-delay="{{ $delay }}">

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
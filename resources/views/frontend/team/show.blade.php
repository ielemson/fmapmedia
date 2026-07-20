@extends('layouts.app')

@section('title', $teamMember->full_name . ' | FutureMap Media')

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', [
        'header' => 'Team Profile'
    ])

    @php
        $profileUrl = route('team.member.show', $teamMember->slug);

        $profileImage = $teamMember->image
            ? asset('storage/' . $teamMember->image)
            : asset('frontend/images/team/default-profile.jpg');

        $fullName = $teamMember->full_name;

        $joinedDate = $teamMember->created_at
            ? $teamMember->created_at->format('F Y')
            : null;

        $socialLinks = collect([
            [
                'url' => $teamMember->facebook,
                'icon' => 'fab fa-facebook-f',
                'label' => 'Facebook',
            ],
            [
                'url' => $teamMember->instagram,
                'icon' => 'fab fa-instagram',
                'label' => 'Instagram',
            ],
            [
                'url' => $teamMember->twitter,
                'icon' => 'fab fa-twitter',
                'label' => 'Twitter',
            ],
            [
                'url' => $teamMember->linkedin,
                'icon' => 'fab fa-linkedin-in',
                'label' => 'LinkedIn',
            ],
            [
                'url' => $teamMember->youtube,
                'icon' => 'fab fa-youtube',
                'label' => 'YouTube',
            ],
            [
                'url' => $teamMember->website,
                'icon' => 'fas fa-globe',
                'label' => 'Website',
            ],
        ])->filter(fn ($link) => filled($link['url']));
    @endphp

    <div class="content-inner bg-img-fix">
        <div class="container">

            <div class="row">

                {{-- Sidebar --}}
                <div class="col-xl-4 col-lg-4 m-b30 dz-order-1">

                    <aside class="side-bar sticky-top left">

                        {{-- Profile Card --}}
                        <div class="widget">
                            <div class="team-profile-card text-center">

                                <div class="team-profile-image mb-4">
                                    <img
                                        src="{{ $profileImage }}"
                                        alt="{{ $fullName }}"
                                        class="img-fluid"
                                    >
                                </div>

                                <h3 class="mb-1">
                                    {{ $fullName }}
                                </h3>

                                <h6 class="text-primary mb-2">
                                    {{ $teamMember->position }}
                                </h6>

                                @if($teamMember->department)
                                    <p class="text-muted mb-3">
                                        {{ $teamMember->department }}
                                    </p>
                                @endif

                                @if($teamMember->short_bio)
                                    <p class="mb-3">
                                        {{ $teamMember->short_bio }}
                                    </p>
                                @endif

                                @if($socialLinks->isNotEmpty())
                                    <ul class="dz-social-icon justify-content-center">

                                        @foreach($socialLinks as $social)
                                            <li>
                                                <a
                                                    href="{{ $social['url'] }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="{{ $social['icon'] }}"
                                                    title="{{ $social['label'] }}"
                                                    aria-label="{{ $social['label'] }}"
                                                ></a>
                                            </li>
                                        @endforeach

                                    </ul>
                                @endif

                            </div>
                        </div>

                        {{-- Contact Information --}}
                        @if($teamMember->user?->email || $teamMember->user?->phone)
                            <div class="widget widget_categories">

                                <div class="widget-title">
                                    <h5 class="title">Contact Information</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <ul>

                                    @if($teamMember->user?->email)
                                        <li>
                                            <a href="mailto:{{ $teamMember->user->email }}">
                                                <i class="far fa-envelope me-2"></i>
                                                {{ $teamMember->user->email }}
                                            </a>
                                        </li>
                                    @endif

                                    @if($teamMember->user?->phone)
                                        <li>
                                            <a href="tel:{{ $teamMember->user->phone }}">
                                                <i class="fas fa-phone-alt me-2"></i>
                                                {{ $teamMember->user->phone }}
                                            </a>
                                        </li>
                                    @endif

                                </ul>

                            </div>
                        @endif

                        {{-- Related Team Members --}}
                        @if(isset($relatedTeamMembers) && $relatedTeamMembers->isNotEmpty())
                            <div class="widget recent-posts-entry">

                                <div class="widget-title">
                                    <h5 class="title">Other Team Members</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                <div class="widget-post-bx">

                                    @foreach($relatedTeamMembers as $member)
                                        @php
                                            $memberImage = $member->image
                                                ? asset('storage/' . $member->image)
                                                : asset('frontend/images/team/default-profile.jpg');
                                        @endphp

                                        <div class="widget-post clearfix">

                                            <div class="dz-media">
                                                <a href="{{ route('team.member.show', $member->slug) }}">
                                                    <img
                                                        src="{{ $memberImage }}"
                                                        alt="{{ $member->full_name }}"
                                                        loading="lazy"
                                                    >
                                                </a>
                                            </div>

                                            <div class="dz-info">

                                                <h4 class="title">
                                                    <a href="{{ route('team.member.show', $member->slug) }}">
                                                        {{ $member->full_name }}
                                                    </a>
                                                </h4>

                                                <div class="dz-meta">
                                                    <ul>
                                                        <li>
                                                            {{ $member->position }}
                                                        </li>
                                                    </ul>
                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        @endif

                    </aside>

                </div>

                {{-- Main Profile Content --}}
                <div class="col-xl-8 col-lg-8 m-b20">

                    <article class="dz-card blog-single sidebar style-1">

                        <div class="dz-info">

                            <div class="mb-3">

                                @if($teamMember->is_featured)
                                    <span class="badge bg-primary me-1">
                                        Featured Team Member
                                    </span>
                                @endif

                                @if($teamMember->department)
                                    <span class="badge bg-light text-dark me-1">
                                        {{ $teamMember->department }}
                                    </span>
                                @endif

                            </div>

                            <div class="dz-meta">
                                <ul>

                                    <li>
                                        <i class="far fa-user me-1"></i>
                                        {{ $teamMember->position }}
                                    </li>

                                    @if($teamMember->qualification)
                                        <li>
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            {{ $teamMember->qualification }}
                                        </li>
                                    @endif

                                    @if(!is_null($teamMember->years_of_experience))
                                        <li>
                                            <i class="fas fa-briefcase me-1"></i>

                                            {{ $teamMember->years_of_experience }}

                                            {{ Str::plural(
                                                'Year',
                                                $teamMember->years_of_experience
                                            ) }}

                                            Experience
                                        </li>
                                    @endif

                                </ul>
                            </div>

                            <h1 class="dz-title">
                                {{ $fullName }}
                            </h1>

                            <h4 class="text-primary">
                                {{ $teamMember->position }}
                            </h4>

                            @if($teamMember->short_bio)
                                <div class="news-summary mt-3">
                                    <p class="lead mb-0">
                                        {{ $teamMember->short_bio }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        {{-- Main Profile Image --}}
                        <div class="dz-media">

                            <img
                                src="{{ $profileImage }}"
                                alt="{{ $fullName }}"
                                class="img-fluid w-100"
                            >

                        </div>

                        <div class="dz-info">

                            {{-- Biography --}}
                            <div class="team-biography">

                                <div class="widget-title mb-3">
                                    <h5 class="title">Biography</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                                @if($teamMember->bio)
                                    <div class="dz-post-text news-content">
                                        {!! $teamMember->bio !!}
                                    </div>
                                @elseif($teamMember->short_bio)
                                    <div class="dz-post-text news-content">
                                        <p>
                                            {{ $teamMember->short_bio }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-muted">
                                        Biography information is not available.
                                    </p>
                                @endif

                            </div>

                            {{-- Professional Information --}}
                            @if(
                                $teamMember->qualification ||
                                $teamMember->specialization ||
                                !is_null($teamMember->years_of_experience) ||
                                $teamMember->department
                            )
                                <div class="team-professional-details mt-5">

                                    <div class="widget-title mb-3">
                                        <h5 class="title">Professional Information</h5>
                                        <div class="dz-separator style-1 text-primary mb-0"></div>
                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-bordered align-middle">

                                            <tbody>

                                                @if($teamMember->position)
                                                    <tr>
                                                        <th width="240">Position</th>
                                                        <td>{{ $teamMember->position }}</td>
                                                    </tr>
                                                @endif

                                                @if($teamMember->department)
                                                    <tr>
                                                        <th>Department</th>
                                                        <td>{{ $teamMember->department }}</td>
                                                    </tr>
                                                @endif

                                                @if($teamMember->qualification)
                                                    <tr>
                                                        <th>Qualification</th>
                                                        <td>{{ $teamMember->qualification }}</td>
                                                    </tr>
                                                @endif

                                                @if($teamMember->specialization)
                                                    <tr>
                                                        <th>Specialization</th>
                                                        <td>{{ $teamMember->specialization }}</td>
                                                    </tr>
                                                @endif

                                                @if(!is_null($teamMember->years_of_experience))
                                                    <tr>
                                                        <th>Years of Experience</th>
                                                        <td>
                                                            {{ $teamMember->years_of_experience }}

                                                            {{ Str::plural(
                                                                'year',
                                                                $teamMember->years_of_experience
                                                            ) }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if($joinedDate)
                                                    <tr>
                                                        <th>Profile Since</th>
                                                        <td>{{ $joinedDate }}</td>
                                                    </tr>
                                                @endif

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            @endif

                            {{-- Social Links --}}
                            @if($socialLinks->isNotEmpty())
                                <div class="team-social-links mt-5">

                                    <div class="widget-title mb-3">
                                        <h5 class="title">Connect</h5>
                                        <div class="dz-separator style-1 text-primary mb-0"></div>
                                    </div>

                                    <div class="row g-3">

                                        @foreach($socialLinks as $social)
                                            <div class="col-xl-4 col-md-6">

                                                <a
                                                    href="{{ $social['url'] }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    class="btn btn-outline-primary w-100"
                                                >
                                                    <i class="{{ $social['icon'] }} me-2"></i>

                                                    {{ $social['label'] }}
                                                </a>

                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            @endif

                            {{-- Share Profile --}}
                            <div class="dz-share-post mt-5">

                                <h5 class="title">Share Profile:</h5>

                                <ul class="dz-social-icon">

                                    <li>
                                        <a
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($profileUrl) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-facebook-f"
                                            title="Share on Facebook"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="https://twitter.com/intent/tweet?url={{ urlencode($profileUrl) }}&text={{ urlencode($fullName . ' - ' . $teamMember->position) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-twitter"
                                            title="Share on X"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="https://wa.me/?text={{ urlencode($fullName . ' - ' . $teamMember->position . ' ' . $profileUrl) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="fab fa-whatsapp"
                                            title="Share on WhatsApp"
                                        ></a>
                                    </li>

                                    <li>
                                        <a
                                            href="mailto:?subject={{ urlencode($fullName . ' | FMAP Media') }}&body={{ urlencode($profileUrl) }}"
                                            class="far fa-envelope"
                                            title="Share by email"
                                        ></a>
                                    </li>

                                </ul>

                            </div>

                        </div>

                    </article>

                    {{-- Related Team Grid --}}
                    @if(isset($relatedTeamMembers) && $relatedTeamMembers->isNotEmpty())
                        <div class="row extra-blog style-1">

                            <div class="col-lg-12">

                                <div class="widget-title">
                                    <h5 class="title">Meet More of Our Team</h5>
                                    <div class="dz-separator style-1 text-primary mb-0"></div>
                                </div>

                            </div>

                            @foreach($relatedTeamMembers as $member)
                                @php
                                    $memberImage = $member->image
                                        ? asset('storage/' . $member->image)
                                        : asset('frontend/images/team/default-profile.jpg');
                                @endphp

                                <div class="col-xl-6 col-md-6">

                                    <div class="dz-team style-1 text-center m-b30 overlay-shine">

                                        <div class="dz-media">

                                            <a href="{{ route('team.member.show', $member->slug) }}">
                                                <img
                                                    src="{{ $memberImage }}"
                                                    alt="{{ $member->full_name }}"
                                                    loading="lazy"
                                                >
                                            </a>

                                            @if(
                                                $member->facebook ||
                                                $member->instagram ||
                                                $member->twitter ||
                                                $member->linkedin
                                            )
                                                <ul class="team-social">

                                                    @if($member->facebook)
                                                        <li>
                                                            <a
                                                                href="{{ $member->facebook }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                            >
                                                                <i class="fab fa-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($member->instagram)
                                                        <li>
                                                            <a
                                                                href="{{ $member->instagram }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                            >
                                                                <i class="fab fa-instagram"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($member->twitter)
                                                        <li>
                                                            <a
                                                                href="{{ $member->twitter }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                            >
                                                                <i class="fab fa-twitter"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                    @if($member->linkedin)
                                                        <li>
                                                            <a
                                                                href="{{ $member->linkedin }}"
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                            >
                                                                <i class="fab fa-linkedin-in"></i>
                                                            </a>
                                                        </li>
                                                    @endif

                                                </ul>
                                            @endif

                                        </div>

                                        <div class="dz-content">

                                            <h5 class="dz-name">
                                                <a href="{{ route('team.member.show', $member->slug) }}">
                                                    {{ $member->full_name }}
                                                </a>
                                            </h5>

                                            <h6 class="dz-position text-primary">
                                                {{ $member->position }}
                                            </h6>

                                            @if($member->department)
                                                <small class="text-muted">
                                                    {{ $member->department }}
                                                </small>
                                            @endif

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

@endsection

@push('styles')
    <style>
        .team-profile-card {
            padding: 25px 20px;
        }

        .team-profile-image {
            width: 220px;
            height: 220px;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid #f5f5f5;
        }

        .team-profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        .team-professional-details table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .team-social-links .btn {
            padding: 12px 15px;
        }

        .dz-card.blog-single .dz-media img {
            max-height: 650px;
            object-fit: cover;
            object-position: top center;
        }

        @media (max-width: 991px) {
            .side-bar.sticky-top {
                position: static !important;
            }
        }

        @media (max-width: 575px) {
            .team-profile-image {
                width: 180px;
                height: 180px;
            }

            .team-professional-details table th {
                width: 150px !important;
            }
        }
    </style>
@endpush
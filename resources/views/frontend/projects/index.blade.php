@extends('layouts.app')

@section('title', 'Our Projects | FutureMap Media')

@section('meta_description',
    'Explore FutureMap Media projects in education, mentoring, counselling, youth development, media and publishing.'
)

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', [
        'header' => 'Our Projects'
    ])

  @php
    $contactUrl = Route::has('contact')
        ? route('contact')
        : route('contact');

    $magazineUrl = Route::has('magazines.index')
        ? route('magazines.index')
        : url('/magazines');

    $projects = [
        [
            'number' => '01',
            'id' => 'futuremap-international-conference',
            'title' => 'The FutureMap International Conference',
            'short_title' => 'International Conference',
            'icon' => 'flaticon-conference',
            'summary' => 'An orientation, mentoring and human-capital development programme created to guide young people towards purposeful educational, career and personal development.',
            'content' => [
                'FutureMap Media worked with The Rejuvenator Initiatives International to launch the FutureMap International Conference as an orientation and mentoring programme.',
                'The programme is designed for secondary school students, secondary school graduates, undergraduates, job seekers, unemployed graduates and other young people seeking guidance and direction.',
                'Through the initiative, FutureMap Media helps beneficiaries clarify their vision, plan their future and develop the confidence required to remain relevant in a changing world.',
                'Technology and modern information-dissemination platforms are also used to connect, inspire and build networks among participants.',
                'The maiden edition was launched on 25 November 2021 and was followed by post-conference engagements at institutions including the Catholic Institute of West Africa, Port Harcourt, and Gregory University, Uturu, Abia State.',
            ],
            'highlights' => [
                'Career orientation and mentoring',
                'Vision development and life planning',
                'Youth networking and exposure',
                'Educational and employability guidance',
            ],
        ],

        [
            'number' => '02',
            'id' => 'counsellors-corner',
            'title' => 'The Counsellors Corner',
            'short_title' => 'Counsellors Corner',
            'icon' => 'flaticon-consulting',
            'summary' => 'A digital counselling platform that connects students with professional guidance for academic, career, emotional and personal-development needs.',
            'content' => [
                'The Counsellors Corner was designed in collaboration with the Secondary Education Board of the Federal Capital Territory, Abuja.',
                'The online platform enables students to gain easier access to counsellors for guidance on career choices, moral concerns, psychological matters, relationships and other personal-development needs.',
                'The project responds to the need for confidential, accessible and timely support for students who may not always have direct access to professional counselling services.',
            ],
            'highlights' => [
                'Career-choice counselling',
                'Moral and behavioural guidance',
                'Psychological support',
                'Relationship and personal-development counselling',
            ],
        ],

        [
            'number' => '03',
            'id' => 'inter-secondary-school-dialogue',
            'title' => 'Inter-Secondary School Dialogue',
            'short_title' => 'School Dialogue',
            'icon' => 'flaticon-education',
            'summary' => 'A student-engagement initiative that brings learners from different schools together to strengthen communication, confidence and constructive relationships.',
            'content' => [
                'The Inter-Secondary School Dialogue was created to expose secondary school students to their counterparts from other schools.',
                'Through guided discussions and interactions, participants build relational confidence, communication ability, teamwork and a broader understanding of their social environment.',
                'The programme began in Owerri, Imo State, and has recorded more than five editions.',
                'Participating institutions have included Regina Caeli Girls Secondary School, Umunachi; Methodist High School, Ikenegbu; Shamash Model Secondary School, Isiekenesi; and Rochas College, Ogboko.',
                'Schools can register to participate in subsequent editions of the programme.',
            ],
            'highlights' => [
                'Inter-school engagement',
                'Public speaking and communication',
                'Confidence and relationship building',
                'Student leadership development',
            ],
        ],

        [
            'number' => '04',
            'id' => 'futuremap-magazine',
            'title' => 'FutureMap Magazine',
            'short_title' => 'FutureMap Magazine',
            'icon' => 'flaticon-newspaper',
            'summary' => 'A youth-led, creatively designed magazine delivering education, news, entertainment, advertising opportunities and a platform for public expression.',
            'content' => [
                'FutureMap Magazine is a youth-led, full-colour and creatively developed media product.',
                'The magazine provides an advertising platform for individuals and organisations while delivering educational information, news, inspiring stories and entertainment to readers.',
                'It also provides contributors with a platform to express ideas, share knowledge and participate in public conversations.',
                'The magazine reflects FutureMap Media’s commitment to human-capital development, market creation, educational service delivery and sustainable media innovation.',
            ],
            'highlights' => [
                'Digital and print media publishing',
                'Advertising and brand exposure',
                'Youth expression and contribution',
                'Education, news and entertainment',
            ],
        ],
    ];
@endphp

<section class="content-inner bg-img-fix">
    <div class="container">

        <div class="row">

            {{-- Main Content --}}
            <div class="col-xl-8 col-lg-8 m-b20">

                <article class="dz-card blog-single sidebar style-1">

                    {{-- Page Introduction --}}
                    <div class="dz-info">

                        <div class="dz-meta">
                            <ul>
                                <li>
                                    <i class="fas fa-briefcase me-1"></i>
                                    Education, Media and Human Development
                                </li>

                                <li>
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Nigeria
                                </li>
                            </ul>
                        </div>

                        <h1 class="dz-title">
                            Previous and Ongoing Projects
                        </h1>

                        <div class="news-summary mt-3">
                            <p class="lead mb-0">
                                We have undertaken projects developed as
                                marketable public products and customised
                                initiatives designed for individual clients,
                                schools, institutions and communities.
                            </p>
                        </div>

                    </div>

                    <div class="dz-info pt-0">

                        {{-- Introductory Content --}}
                        <div class="dz-post-text">

                            <p>
                                FutureMap Media develops projects that combine
                                education, media, mentoring, technology and
                                enterprise development to create meaningful
                                opportunities for individuals and organisations.
                            </p>

                            <p>
                                Our initiatives are structured to inspire
                                creativity, strengthen human capacity, improve
                                access to information and create sustainable
                                platforms for learning, expression and commerce.
                            </p>

                        </div>

                        {{-- Project Navigation --}}
                        <div class="tutorial mb-5">

                            <h4 class="tutorial-border pb-3">
                                Project Overview
                            </h4>

                            <ul>
                                @foreach($projects as $project)
                                    <li>
                                        <a href="#{{ $project['id'] }}">
                                            {{ $project['number'] }}.
                                            {{ $project['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                        {{-- Project Details --}}
                        <div class="tutorial-data">

                            @foreach($projects as $project)

                                <section
                                    id="{{ $project['id'] }}"
                                    class="project-detail-section"
                                >

                                    <div class="project-heading">

                                        <span class="project-number">
                                            {{ $project['number'] }}
                                        </span>

                                        <div class="project-heading-content">

                                            <small class="text-primary fw-semibold">
                                                FutureMap Media Project
                                            </small>

                                            <h3 class="mb-2">
                                                {{ $project['title'] }}
                                            </h3>

                                            <p class="project-summary mb-0">
                                                {{ $project['summary'] }}
                                            </p>

                                        </div>

                                    </div>

                                    <div class="project-description mt-4">

                                        @foreach($project['content'] as $paragraph)
                                            <p>
                                                {{ $paragraph }}
                                            </p>
                                        @endforeach

                                    </div>

                                    <div class="project-highlights mt-4">

                                        <h5 class="mb-4">
                                            Project Focus
                                        </h5>

                                        <div class="row g-3">

                                            @foreach($project['highlights'] as $highlight)

                                                <div class="col-md-6">

                                                    <div class="project-highlight-item">

                                                        <i class="fas fa-check-circle"></i>

                                                        <span>
                                                            {{ $highlight }}
                                                        </span>

                                                    </div>

                                                </div>

                                            @endforeach

                                        </div>

                                    </div>

                                </section>

                            @endforeach

                        </div>

                        {{-- Quote --}}
                        <blockquote class="block-quote style-1 mt-5">
                            <p>
                                “In every human are bundles of possibilities.
                                We build human capital and create market fields
                                through education, media and enterprise.”
                            </p>

                            <cite>FutureMap Media</cite>
                        </blockquote>

                        {{-- Closing Content --}}
                        <div class="dz-post-text mt-5">

                            <h4>
                                Building Sustainable Opportunities
                            </h4>

                            <p>
                                FutureMap Media remains committed to transforming
                                lives through business initiatives, educational
                                services, media exposure and innovative market
                                platforms.
                            </p>

                            <p>
                                We welcome partnerships with schools, public
                                institutions, private organisations, development
                                agencies and individuals who share our commitment
                                to youth development, creativity and sustainable
                                growth.
                            </p>

                        </div>

                        {{-- Call to Action --}}
                        <div class="project-cta mt-5">

                            <div class="row align-items-center">

                                <div class="col-lg-8">

                                    <span class="text-primary fw-semibold">
                                        Partner With FutureMap Media
                                    </span>

                                    <h3 class="mt-2 mb-2">
                                        Let us develop your next impactful project
                                    </h3>

                                    <p class="mb-lg-0">
                                        Work with our team on educational programmes,
                                        media campaigns, youth initiatives and
                                        customised institutional projects.
                                    </p>

                                </div>

                                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

                                    <a
                                        href="{{ $contactUrl }}"
                                        class="btn btn-primary btn-icon"
                                    >
                                        Contact Us

                                        <i class="fas fa-caret-right ms-1"></i>
                                    </a>

                                </div>

                            </div>

                        </div>

                        {{-- Share --}}
                        <div class="dz-share-post mt-5">

                            <h5 class="title">
                                Share:
                            </h5>

                            @php
                                $projectsUrl = url()->current();
                                $shareTitle = 'Our Projects | FutureMap Media';
                            @endphp

                            <ul class="dz-social-icon">

                                <li>
                                    <a
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($projectsUrl) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="fab fa-facebook-f"
                                        title="Share on Facebook"
                                    ></a>
                                </li>

                                <li>
                                    <a
                                        href="https://twitter.com/intent/tweet?url={{ urlencode($projectsUrl) }}&text={{ urlencode($shareTitle) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="fab fa-twitter"
                                        title="Share on X"
                                    ></a>
                                </li>

                                <li>
                                    <a
                                        href="https://wa.me/?text={{ urlencode($shareTitle . ' ' . $projectsUrl) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="fab fa-whatsapp"
                                        title="Share on WhatsApp"
                                    ></a>
                                </li>

                                <li>
                                    <a
                                        href="mailto:?subject={{ urlencode($shareTitle) }}&body={{ urlencode($projectsUrl) }}"
                                        class="far fa-envelope"
                                        title="Share by email"
                                    ></a>
                                </li>

                            </ul>

                        </div>

                    </div>

                </article>

            </div>

            {{-- Sidebar --}}
            <div class="col-xl-4 col-lg-4 m-b30 dz-order-1">

                <aside class="side-bar sticky-top right">

                    {{-- Project Navigation --}}
                    <div class="widget widget_categories">

                        <div class="widget-title">
                            <h5 class="title">
                                Our Projects
                            </h5>

                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>

                        <ul>

                            @foreach($projects as $project)
                                <li class="cat-item">

                                    <a href="#{{ $project['id'] }}">
                                        {{ $project['short_title'] }}
                                    </a>

                                    <span>
                                        {{ $project['number'] }}
                                    </span>

                                </li>
                            @endforeach

                        </ul>

                    </div>

                    {{-- Organisational Focus --}}
                    <div class="widget widget_categories">

                        <div class="widget-title">
                            <h5 class="title">
                                Our Focus Areas
                            </h5>

                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>

                        <ul>

                            <li>
                                <span>
                                    <i class="fas fa-graduation-cap me-2"></i>
                                    Education
                                </span>
                            </li>

                            <li>
                                <span>
                                    <i class="fas fa-users me-2"></i>
                                    Youth Development
                                </span>
                            </li>

                            <li>
                                <span>
                                    <i class="fas fa-bullhorn me-2"></i>
                                    Media and Publicity
                                </span>
                            </li>

                            <li>
                                <span>
                                    <i class="fas fa-laptop me-2"></i>
                                    Digital Innovation
                                </span>
                            </li>

                            <li>
                                <span>
                                    <i class="fas fa-handshake me-2"></i>
                                    Partnerships
                                </span>
                            </li>

                        </ul>

                    </div>

                    {{-- Magazine --}}
                    <div class="widget project-sidebar-card">

                        <div class="project-sidebar-content">

                            <div class="project-sidebar-icon">
                                <i class="fas fa-book-open"></i>
                            </div>

                            <span class="text-primary fw-semibold">
                                FutureMap Magazine
                            </span>

                            <h4>
                                Discover our latest magazine editions
                            </h4>

                            <p>
                                Access inspiring stories, interviews,
                                educational content and business insights.
                            </p>

                            <a
                                href="{{ $magazineUrl }}"
                                class="btn btn-primary btn-sm"
                            >
                                Explore Magazine
                            </a>

                        </div>

                    </div>

                    {{-- Contact --}}
                    <div class="widget project-contact-widget">

                        <div class="widget-title">
                            <h5 class="title">
                                Start a Project
                            </h5>

                            <div class="dz-separator style-1 text-primary mb-0"></div>
                        </div>

                        <p>
                            Speak with our team about partnerships,
                            sponsorship, media services or educational
                            programme development.
                        </p>

                        <ul class="project-contact-list">

                            <li>
                                <i class="fas fa-phone-alt"></i>

                                <div>
                                    <small>Call Us</small>

                                    <a href="tel:08035082149">
                                        08035082149
                                    </a>
                                </div>
                            </li>

                            <li>
                                <i class="far fa-envelope"></i>

                                <div>
                                    <small>Email Us</small>

                                    <a href="mailto:info@fmapmedia.com">
                                        info@fmapmedia.com
                                    </a>
                                </div>
                            </li>

                        </ul>

                        <a
                            href="{{ $contactUrl }}"
                            class="btn btn-outline-primary w-100"
                        >
                            Send an Enquiry
                        </a>

                    </div>

                </aside>

            </div>

        </div>

    </div>
</section>

@push('styles')
    <style>
        html {
            scroll-behavior: smooth;
        }

        .project-detail-section {
            position: relative;
            scroll-margin-top: 130px;
            padding: 15px 0 55px;
            margin-bottom: 45px;
            border-bottom: 1px solid #e8e8e8;
        }

        .project-detail-section:last-child {
            margin-bottom: 0;
            padding-bottom: 15px;
            border-bottom: 0;
        }

        .project-heading {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 28px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 5px solid var(--primary);
        }

        .project-heading-content {
            flex: 1;
        }

        .project-heading h3 {
            margin-top: 4px;
        }

        .project-summary {
            color: #626262;
            line-height: 1.7;
        }

        .project-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            min-width: 68px;
            height: 68px;
            border-radius: 50%;
            background: var(--primary);
            color: #ffffff;
            font-size: 21px;
            font-weight: 700;
            line-height: 1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .project-description p {
            line-height: 1.85;
        }

        .project-highlights {
            padding: 25px;
            border-radius: 10px;
            background: #f8f9fa;
        }

        .project-highlight-item {
            display: flex;
            align-items: flex-start;
            gap: 11px;
            height: 100%;
            padding: 15px 16px;
            background: #ffffff;
            border: 1px solid #e8e8e8;
            border-radius: 7px;
            transition: all 0.25s ease;
        }

        .project-highlight-item:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }

        .project-highlight-item i {
            color: var(--primary);
            margin-top: 4px;
        }

        .project-cta {
            padding: 35px;
            border-radius: 10px;
            background: #f6f8fb;
            border-left: 5px solid var(--primary);
        }

        .project-sidebar-card {
            overflow: hidden;
            padding: 0 !important;
        }

        .project-sidebar-content {
            padding: 30px 25px;
        }

        .project-sidebar-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 65px;
            height: 65px;
            margin-bottom: 20px;
            border-radius: 50%;
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary);
            font-size: 26px;
        }

        .project-contact-list {
            margin: 0 0 25px;
            padding: 0;
            list-style: none;
        }

        .project-contact-list li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 13px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .project-contact-list li:last-child {
            border-bottom: 0;
        }

        .project-contact-list i {
            color: var(--primary);
            font-size: 18px;
            margin-top: 5px;
        }

        .project-contact-list small {
            display: block;
            color: #777777;
            margin-bottom: 2px;
        }

        .project-contact-list a {
            color: inherit;
            font-weight: 600;
        }

        .widget_categories ul li span i {
            color: var(--primary);
        }

        @media (max-width: 991px) {
            .side-bar.sticky-top {
                position: static !important;
            }
        }

        @media (max-width: 575px) {
            .project-heading {
                gap: 14px;
                padding: 20px;
            }

            .project-number {
                width: 50px;
                min-width: 50px;
                height: 50px;
                font-size: 16px;
            }

            .project-heading h3 {
                font-size: 21px;
            }

            .project-highlights,
            .project-cta {
                padding: 20px;
            }
        }
    </style>
@endpush

@endsection

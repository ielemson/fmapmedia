@extends('layouts.app')

@section('title', 'Magazines | FutureMap Media')

@section(
    'meta_description',
    'Browse and purchase the latest editions of FutureMap Magazine.'
)

@section('header')
    @include('frontend.partials.page-header')
@endsection

@section('content')

    @include('frontend.partials.banner', [
        'header' => 'Magazines'
    ])

    <section class="content-inner-1">
        <div class="container">

            <div class="section-head style-2 text-center">
                <h6 class="text-primary sub-title">
                    FMAP Publications
                </h6>

                <h2 class="title">
                    Latest Magazine Issues
                </h2>

                <p class="mt-3">
                    Browse the latest editions of FutureMap Magazine and
                    purchase your preferred digital issue securely online.
                </p>
            </div>

            {{-- Search and Filter --}}
            <div class="magazine-filter-box mb-5">

                <form
                    action="{{ route('magazines.index') }}"
                    method="GET"
                    class="row g-3 align-items-end"
                >

                    <div class="col-lg-6 col-md-6">

                        <label for="search" class="form-label">
                            Search Magazine
                        </label>

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search by magazine title..."
                            >

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="fa fa-search me-1"></i>
                                Search
                            </button>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-3">

                        <label for="sort" class="form-label">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            id="sort"
                            class="form-select"
                            onchange="this.form.submit()"
                        >
                            <option
                                value="latest"
                                @selected(request('sort', 'latest') === 'latest')
                            >
                                Latest Issues
                            </option>

                            <option
                                value="oldest"
                                @selected(request('sort') === 'oldest')
                            >
                                Oldest Issues
                            </option>

                            <option
                                value="price_low"
                                @selected(request('sort') === 'price_low')
                            >
                                Price: Low to High
                            </option>

                            <option
                                value="price_high"
                                @selected(request('sort') === 'price_high')
                            >
                                Price: High to Low
                            </option>
                        </select>

                    </div>

                    <div class="col-lg-3 col-md-3">

                        @if(request()->filled('search') || request('sort') !== null)
                            <a
                                href="{{ route('magazines.index') }}"
                                class="btn btn-outline-secondary w-100"
                            >
                                <i class="fa fa-undo me-1"></i>
                                Reset Filter
                            </a>
                        @endif

                    </div>

                </form>

            </div>

            {{-- Magazine Grid --}}
            <div class="row g-4">

                @forelse($magazines as $magazine)

                    @php
                        $magazineImage = $magazine->image
                            ? asset('storage/' . $magazine->image)
                            : asset('frontend/images/default-magazine.jpg');

                        $publishedDate = $magazine->published_at
                            ? $magazine->published_at->format('d M Y')
                            : null;
                    @endphp

                    <div class="col-xl-4 col-lg-4 col-md-6">

                        <div
                            class="dz-card blog-grid style-2 h-100 aos-item magazine-card"
                            data-aos="fade-up"
                            data-aos-duration="1200"
                            data-aos-delay="{{ 200 + (($loop->index % 3) * 100) }}"
                        >

                            <div class="dz-media position-relative">

                                <a href="{{ route('magazine.show', $magazine->slug) }}">

                                    <img
                                        src="{{ $magazineImage }}"
                                        alt="{{ $magazine->name }}"
                                        loading="lazy"
                                    >

                                </a>

                                <span class="badge bg-primary magazine-price-badge">
                                    ₦{{ number_format($magazine->price, 2) }}
                                </span>

                                @if($magazine->competition_status === 'active')
                                    <span class="badge bg-success magazine-competition-badge">
                                        Competition Active
                                    </span>
                                @endif

                            </div>

                            <div class="dz-info text-center d-flex flex-column">

                                @if($publishedDate)
                                    <div class="dz-meta">
                                        <ul class="justify-content-center">

                                            <li class="post-date">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $publishedDate }}
                                            </li>

                                        </ul>
                                    </div>
                                @endif

                                <h5 class="dz-title">

                                    <a href="{{ route('magazine.show', $magazine->slug) }}">
                                        {{ $magazine->name }}
                                    </a>

                                </h5>

                                @if($magazine->desc)
                                    <div class="dz-post-text flex-grow-1">

                                        <p>
                                            {{ Str::limit(
                                                strip_tags($magazine->desc),
                                                120
                                            ) }}
                                        </p>

                                    </div>
                                @endif

                                <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">

                                    <a
                                        href="{{ route('magazine.show', $magazine->slug) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4"
                                    >
                                        <i class="fa fa-eye me-1"></i>
                                        View Details
                                    </a>

                                    <a
                                        href="{{ route('checkout.show', $magazine->slug) }}"
                                        class="btn btn-primary btn-sm rounded-pill px-4"
                                    >
                                        <i class="fa fa-shopping-cart me-1"></i>
                                        Buy Now
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="magazine-empty-state text-center">

                            <i class="far fa-newspaper"></i>

                            <h4 class="mt-3">
                                No magazines available
                            </h4>

                            <p class="text-muted mb-0">
                                There are currently no published magazine issues.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

            {{-- Pagination --}}
            @if($magazines->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $magazines->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
    <style>
        .magazine-filter-box {
            padding: 25px;
            background: #f8f9fa;
            border: 1px solid #eeeeee;
            border-radius: 10px;
        }

        .magazine-card {
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .magazine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }

        .magazine-card .dz-media {
            overflow: hidden;
            background: #f5f5f5;
        }

        .magazine-card .dz-media img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.4s ease;
        }

        .magazine-card:hover .dz-media img {
            transform: scale(1.03);
        }

        .magazine-card .dz-info {
            flex: 1;
        }

        .magazine-price-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 9px 14px;
            font-size: 14px;
            z-index: 2;
        }

        .magazine-competition-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 9px 12px;
            z-index: 2;
        }

        .magazine-empty-state {
            padding: 70px 20px;
            border: 1px dashed #cccccc;
            border-radius: 10px;
            background: #fafafa;
        }

        .magazine-empty-state i {
            font-size: 60px;
            color: var(--primary);
        }

        @media (max-width: 1199px) {
            .magazine-card .dz-media img {
                height: 400px;
            }
        }

        @media (max-width: 767px) {
            .magazine-filter-box {
                padding: 20px;
            }

            .magazine-card .dz-media img {
                height: auto;
                max-height: 520px;
            }
        }
    </style>
@endpush
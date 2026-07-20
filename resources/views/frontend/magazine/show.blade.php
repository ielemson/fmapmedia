@extends('layouts.app')

@section('title', 'Home | FutureMap Media')

@section("header")
@include("frontend.partials.page-header")
@endsection

@section('content')

@include("frontend.partials.banner",["header"=>"Magazine"])

<div class="content-inner bg-img-fix">
    <div class="min-container">

        <div class="dz-card blog-single sidebar style-1">

            <div class="dz-info text-center">
                <div class="dz-meta">
                    <ul class="justify-content-center">
                        <li class="post-date">
                            {{ optional($magazine->published_at)->format('d M Y') ?? 'Not Published' }}
                        </li>

                        @if($magazine->category)
                            <li class="post-user">
                                {{ $magazine->category->name }}
                            </li>
                        @endif
                    </ul>
                </div>

                <h2 class="dz-title">{{ $magazine->name }}</h2>

               
            </div>

            <div class="row align-items-start m-b40">

                <div class="col-lg-6">
                    <div class="dz-media magazine-detail-cover">
                        <img src="{{ asset('storage/' . $magazine->image) }}"
                             alt="{{ $magazine->name }}">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="dz-info magazine-purchase-box">

                        <h4>About This Magazine</h4>

                        <div class="dz-post-text">
                            {!! $magazine->desc !!}
                        </div>

                        {{-- <div class="magazine-info-list mt-4">
                            <div>
                                <span>Publication Date</span>
                                <strong>{{ optional($magazine->published_at)->format('d M Y') ?? 'Not Published' }}</strong>
                            </div>

                            <div>
                                <span>Status</span>
                                <strong>{{ ucfirst($magazine->status) }}</strong>
                            </div>

                            <div>
                                <span>Price</span>
                                <strong>₦{{ number_format($magazine->price, 2) }}</strong>
                            </div>

                            <div>
                                <span>Format</span>
                                <strong>Digital / PDF</strong>
                            </div>
                        </div> --}}

                        <div class="">
                            <a href="{{ route('checkout.show', $magazine->slug) }}"
                               class="btn btn-primary btn-icon">
                                Buy Now - ₦{{ number_format($magazine->price, 2) }}
                                <i class="fas fa-shopping-cart ms-2"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            <div class="dz-info">
                <div class="dz-share-post">
                    <h5 class="title">Share:</h5>
                    <ul class="dz-social-icon">
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                               target="_blank"
                               class="fab fa-facebook-f"></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($magazine->name) }}"
                               target="_blank"
                               class="fab fa-twitter"></a>
                        </li>
                        <li>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($magazine->name . ' - ' . request()->fullUrl()) }}"
                               target="_blank"
                               class="fab fa-whatsapp"></a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        @if($relatedMagazines->count())
            <div class="row extra-blog style-1">
                <div class="col-lg-12">
                    <div class="widget-title">
                        <h5 class="title">Related Magazine Issues</h5>
                        <div class="dz-separator style-1 text-primary mb-0"></div>
                    </div>
                </div>

                @foreach($relatedMagazines as $related)
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="dz-card blog-grid style-1 m-b30">
                            <div class="dz-media">
                                <a href="{{ route('magazine.show', $related->slug) }}">
                                    <img src="{{ asset('storage/' . $related->image) }}"
                                         alt="{{ $related->name }}">
                                </a>
                            </div>

                            <div class="dz-info">
                                <div class="dz-meta">
                                    <ul>
                                        <li class="post-date">
                                            {{ optional($related->published_at)->format('d M Y') }}
                                        </li>
                                    </ul>
                                </div>

                                <h5 class="dz-title">
                                    <a href="{{ route('magazine.show', $related->slug) }}">
                                        {{ $related->name }}
                                    </a>
                                </h5>

                                <div class="dz-post-text text">
                                    <p>{{ Str::limit(strip_tags($related->desc), 90) }}</p>
                                </div>

                                <a href="{{ route('magazine.show', $related->slug) }}"
                                   class="btn-link">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

		
@endsection
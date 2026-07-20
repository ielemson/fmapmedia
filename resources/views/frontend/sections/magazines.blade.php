<!-- FMAP Magazine -->
<section class="content-inner-1">
    <div class="container">
        <div class="section-head style-2 text-center">
            <h6 class="text-primary sub-title">FMAP Publications</h6>
            <h2 class="title">Latest Magazine Issues</h2>
        </div>

        <div class="row g-4">
            @forelse($magazines as $index => $magazine)
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="dz-card blog-grid style-2 h-100 aos-item"
                        data-aos-delay="{{ 200 + $index * 100 }}">

                        <div class="dz-media">
                            <a href="{{ route('magazine.show', $magazine->slug) }}">
                                <img src="{{ asset('storage/' . $magazine->image) }}" alt="{{ $magazine->name }}">
                            </a>

                            <span class="badge bg-primary position-absolute top-0 start-0 m-3">
                                ₦{{ number_format($magazine->price, 2) }}
                            </span>
                        </div>

                        <div class="dz-info text-center">
                            <div class="dz-meta">
                                <ul class="justify-content-center">
                                    <li class="post-date">
                                        {{ optional($magazine->published_at)->format('d M Y') }}
                                    </li>
                                </ul>
                            </div>

                            <h5 class="dz-title">
                                <a href="{{ route('magazine.show', $magazine->slug) }}">
                                    {{ $magazine->name }}
                                </a>
                            </h5>

                            <div class="dz-post-text">
                                <p>
                                    {{ Str::limit(strip_tags($magazine->desc), 120) }}
                                </p>
                            </div>

                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <a href="javascript:;"
                                   class="btn btn-outline-primary btn-sm rounded-pill px-4 btn-read-magazine"
                                   data-title="{{ $magazine->name }}"
                                   data-image="{{ asset('storage/' . $magazine->image) }}"
                                   data-price="₦{{ number_format($magazine->price, 2) }}"
                                   data-date="{{ optional($magazine->published_at)->format('d M Y') }}"
                                   data-description="{{ strip_tags($magazine->desc) }}"
                                   data-checkout="{{ route('checkout.show', $magazine->slug) }}">
                                    <i class="fa fa-eye me-1"></i> Read More
                                </a>

                                <a href="{{ route('checkout.show', $magazine->slug) }}"
                                   class="btn btn-primary btn-sm rounded-pill px-4">
                                    <i class="fa fa-shopping-cart me-1"></i> Buy Now
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5>No magazines available.</h5>
                </div>
            @endforelse
        </div>

        @if($magazines->count() >= 6)
            <div class="text-center mt-5">
                <a href="{{ route('magazines.index') }}"
                   class="btn btn-primary rounded-pill px-5 py-3">
                    View More Magazines
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        @endif

    </div>
</section>


@push("scripts")
    <script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-read-magazine').forEach(function (button) {

        button.addEventListener('click', function () {

            Swal.fire({
                width: '900px',
    showConfirmButton: false,
    showCloseButton: true,
    customClass: {
        popup: 'fmap-magazine-popup'
    },

                html: `
                    <div class="row align-items-center">

                        <div class="col-md-5 text-center">
                            <img src="${this.dataset.image}"
                                 class="img-fluid rounded shadow"
                                 style="max-height:450px;">
                        </div>

                        <div class="col-md-7 text-start">

                            <h3 class="mb-2">${this.dataset.title}</h3>

                            <h4 class="text-primary mb-3">
                                ${this.dataset.price}
                            </h4>

                            <p class="text-muted mb-3">
                                <strong>Published:</strong>
                                ${this.dataset.date}
                            </p>

                            <div style="max-height:220px;overflow:auto;">
                                ${this.dataset.description}
                            </div>

                            <div class="mt-4">
                                <a href="${this.dataset.checkout}"
                                   class="btn btn-primary">
                                    <i class="fa fa-shopping-cart me-2"></i>
                                    Buy Now
                                </a>
                            </div>

                        </div>

                    </div>
                `
            });

        });

    });

});
</script>
@endpush
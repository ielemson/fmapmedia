	<div class="dz-bnr-inr style-1 overlay-white-middle" style="background-image: url({{ asset("frontend/images/banner/banner.jpg") }});">
			<div class="container">
				<div class="dz-bnr-inr-entry">
					<h1>{{ $header ?? "" }}</h1>
					<!-- Breadcrumb Row -->
					<nav aria-label="breadcrumb" class="breadcrumb-row">
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route("index") }}">Home</a></li>
							<li class="breadcrumb-item">{{ $header ?? "" }}</li>
						</ul>
					</nav>
					<!-- Breadcrumb Row End -->
				</div>
			</div>
		</div>
<footer class="footer">
    <div class="footer-content">
        <div class="footer-brand">
            <span class="footer-brand-mark">
                <img src="{{ asset('backend/assets/img/logo.png') }}" alt="FMAP Media">
            </span>
            <div>
                <strong>FMAP Media</strong>
                <span>News, magazine and marketplace admin workspace</span>
            </div>
        </div>

        <div class="footer-links">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            {{-- <a href="{{ route('admin.news.index') }}">News</a> --}}
            {{-- <a href="{{ route('admin.products.index') }}">Products</a> --}}
            {{-- <a href="{{ route('admin.users.index') }}">Users</a> --}}
        </div>

        <div class="footer-meta">
            <div class="footer-copyright">
                &copy; {{ date('Y') }}
                <a href="{{ route('dashboard') }}">FMAP Media</a>.
                All Rights Reserved.
            </div>

            <div class="footer-credits">
                <div class="credits">
                    Powered by FMAP Media Admin System
                </div>
            </div>
        </div>
    </div>
</footer>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'dashboard' ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
                    <span data-feather="home"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'anggota' ? 'active' : '' }}" href="{{ route('anggota') }}">
                    <span data-feather="users"></span>
                    Anggota
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'buku' ? 'active' : '' }}" href="{{ route('buku') }}">
                    <span data-feather="book"></span>
                    Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::segment(1) === 'laporan' ? 'active' : '' }}" href="{{ route('laporan') }}">
                    <span data-feather="file-text"></span>
                    Laporan
                </a>
            </li>
        </ul>
    </div>
</nav>

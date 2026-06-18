<nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar" style="padding-top: 1rem;">
    <div class="position-sticky">
        <h6 class="sidebar-heading px-3 mb-2 text-white-50">Menu</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('/') && !request()->is('customer*') ? 'active bg-primary' : '' }}" href="/">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('transaction') ? 'active bg-primary' : '' }}" href="/transaction">
                    <i class="bi bi-cart-plus me-2"></i> Input Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('transaction/upload') ? 'active bg-primary' : '' }}" href="/transaction/upload">
                    <i class="bi bi-upload me-2"></i> Upload Excel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('customer*') ? 'active bg-primary' : '' }}" href="/customer">
                    <i class="bi bi-people me-2"></i> Customer
                </a>
            </li>
        </ul>

        <h6 class="sidebar-heading px-3 mt-4 mb-2 text-white-50">Admin</h6>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->is('account*') ? 'active bg-primary' : '' }}" href="/account/admin">
                    <i class="bi bi-person-badge me-2"></i> Manajemen Akun
                </a>
            </li>
        </ul>

        <hr class="text-white-50 mx-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <form action="/logout" method="POST" class="px-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>

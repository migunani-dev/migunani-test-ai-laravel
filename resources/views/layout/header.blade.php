<header class="navbar navbar-dark bg-dark sticky-top px-3 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">
        <i class="bi bi-box-seam me-2"></i>Migunani Test
    </a>
    <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="ms-auto text-white">
        <span class="me-2">{{ auth()->user()->name ?? 'User' }}</span>
        <span class="badge bg-secondary">{{ auth()->user()->status ?? '-' }}</span>
    </div>
</header>

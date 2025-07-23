<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= BASE_URL ?>" class="brand-link">
            <img
                    src="<?= BASE_URL ?>adminlte/dist/assets/img/AdminLTELogo.png"
                    alt="OtoRezerv Logo"
                    class="brand-image opacity-75 shadow"
            />
            <span class="brand-text fw-light">OtoRezerv</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                    class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="navigation"
                    aria-label="Main navigation"
                    data-accordion="false"
                    id="navigation"
            >
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>" class="nav-link <?= ($current_page === 'dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Anasayfa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL ?>pages/vehicles"  class="nav-link <?= ($current_page === 'vehicles') ? 'active' : '' ?>">
                        <i class="nav-icon bi bi-palette"></i>
                        <p>Araçlar</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

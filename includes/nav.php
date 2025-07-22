
<!--begin::Header-->
<nav class="app-header navbar navbar-expand bg-body">
<!--<nav class="app-header navbar navbar-expand bg-danger" data-bs-theme="light">-->
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Home</a></li>
            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link">Contact</a></li>
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Navbar Search-->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>
            <!--end::Navbar Search-->
            <!--begin::Notifications Dropdown Menu-->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> 4 new messages
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-people-fill me-2"></i> 8 friend requests
                        <span class="float-end text-secondary fs-7">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-file-earmark-fill me-2"></i> 3 new reports
                        <span class="float-end text-secondary fs-7">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer"> See All Notifications </a>
                </div>
            </li>
            <!--end::Notifications Dropdown Menu-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->

            <li>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <button
                                class="btn btn-link nav-link py-2 px-0 px-lg-2 dropdown-toggle d-flex align-items-center"
                                id="bd-theme"
                                type="button"
                                aria-expanded="false"
                                data-bs-toggle="dropdown"
                                data-bs-display="static"
                        >
                      <span class="theme-icon-active">
                        <i class="my-1"></i>
                      </span>
                            <span class="d-lg-none ms-2" id="bd-theme-text">Toggle theme</span>
                        </button>
                        <ul
                                class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="bd-theme-text"
                                style="--bs-dropdown-min-width: 8rem;"
                        >
                            <li>
                                <button
                                        type="button"
                                        class="dropdown-item d-flex align-items-center active"
                                        data-bs-theme-value="light"
                                        aria-pressed="false"
                                >
                                    <i class="bi bi-sun-fill me-2"></i>
                                    Light
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>
                                <button
                                        type="button"
                                        class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="dark"
                                        aria-pressed="false"
                                >
                                    <i class="bi bi-moon-fill me-2"></i>
                                    Dark
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                            <li>
                                <button
                                        type="button"
                                        class="dropdown-item d-flex align-items-center"
                                        data-bs-theme-value="auto"
                                        aria-pressed="true"
                                >
                                    <i class="bi bi-circle-fill-half-stroke me-2"></i>
                                    Auto
                                    <i class="bi bi-check-lg ms-auto d-none"></i>
                                </button>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="<?= BASE_URL ?>adminlte/dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline"><?=$_SESSION["user_fullname"]?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="<?= BASE_URL ?>adminlte/dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image" />
                        <p>
                            <?=$_SESSION["user_fullname"]?> - <?=ucfirst($_SESSION["selected_company_role"])?>
                            <small>Aktif Firma: <span id="current-company-name">Yükleniyor...</span></small>
                        </p>
                    </li>

                    <li class="user-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <select id="company-switcher" class="form-control form-control-sm">
                                </select>
                            </div>
                        </div>
                    </li>

                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profil</a>
                        <a href="logout.php" class="btn btn-default btn-flat float-end">Çıkış</a>
                    </li>
                </ul>
            </li>

            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
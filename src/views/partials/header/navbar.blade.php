<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="/assets/images/logo.svg" class="mr-2"
                alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="/assets/images/logo-mini.svg"
                alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block badge bg-primary">
                <i class="fa-regular fa-clock" style="color: white"></i>
                <span class="text-light" id="time-badge">
                    00:00:00
                </span>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
                <button class="btn btn-outline-info btn-icon-text btn-sm ">
                    <i class="fa-regular fa-bell fa-lg btn-icon-append mr-2"></i>
                    0
                </button>
            </li>
            <li class="nav-item">
                <a class="btn btn-primary btn-sm" href="<?= $_ENV['APP_URL'] ?>/logout">
                    Đăng xuất
                </a>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>

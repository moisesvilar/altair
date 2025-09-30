<!DOCTYPE html>
<html lang="es">
<head>
    <title><?= $title ?? 'Dashboard - Altair' ?></title>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Altair">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="/assets/images/favicon.png">
    <link href="/assets/vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/nouislider/nouislider.min.css">
    <link href="/assets/css/style.css" rel="stylesheet">
    
    <?= $additionalStyles ?? '' ?>
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="dashboard.php" class="brand-logo">
                <svg class="logo-abbr" width="55" height="55" viewBox="0 0 55 55" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.5 0C12.3122 0 0 12.3122 0 27.5C0 42.6878 12.3122 55 27.5 55C42.6878 55 55 42.6878 55 27.5C55 12.3122 42.6878 0 27.5 0ZM28.0092 46H19L19.0001 34.9784L19 27.5803V24.4779C19 14.3752 24.0922 10 35.3733 10V17.5571C29.8894 17.5571 28.0092 19.4663 28.0092 24.4779V27.5803H36V34.9784H28.0092V46Z" fill="url(#paint0_linear)"/>
                    <defs>
                        <linearGradient id="paint0_linear" x1="27.5" y1="0" x2="27.5" y2="55" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#7A6FBE"/>
                            <stop offset="1" stop-color="#2E2DDF"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div class="brand-title">
                    <h2 class="text-primary m-0">Altair</h2>
                    <span class="brand-sub-title">SaaS Admin</span>
                </div>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
        
        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                <?= $pageTitle ?? 'Dashboard' ?>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <!-- User Profile -->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="/assets/images/profile/pic1.jpg" width="20" alt="user">
                                    <span class="ms-2"><?= htmlspecialchars($userName ?? 'Usuario') ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="profile.php" class="dropdown-item ai-icon">
                                        <span class="ms-2">Perfil</span>
                                    </a>
                                    <a href="logout.php" class="dropdown-item ai-icon">
                                        <span class="ms-2">Cerrar Sesión</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="dropdown header-profile">
                        <div class="header-info ms-3">
                            <span class="font-w600"><?= htmlspecialchars($userName ?? 'Usuario') ?></span>
                            <small class="text-end font-w400"><?= htmlspecialchars($userEmail ?? 'usuario@ejemplo.com') ?></small>
                        </div>
                    </li>
                    
                    <!-- Dashboard -->
                    <li class="mm-active">
                        <a href="dashboard.php" aria-expanded="false">
                            <i class="flaticon-025-dashboard"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Tenants Management -->
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-050-info"></i>
                            <span class="nav-text">Tenants</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="#">Lista de Tenants</a></li>
                            <li><a href="#">Crear Tenant</a></li>
                        </ul>
                    </li>
                    
                    <!-- Users Management -->
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-013-checkmark"></i>
                            <span class="nav-text">Usuarios</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="#">Lista de Usuarios</a></li>
                            <li><a href="#">Crear Usuario</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
        
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <?php if (isset($flashMessage)): ?>
                    <div class="alert alert-<?= $flashType ?? 'info' ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($flashMessage) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?= $content ?>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Altair Team <?= date('Y') ?></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!-- Scripts -->
    <script src="/assets/vendor/global/global.min.js"></script>
    <script src="/assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="/assets/vendor/chart-js/chart.bundle.min.js"></script>
    <script src="/assets/vendor/owl-carousel/owl.carousel.js"></script>
    <script src="/assets/vendor/peity/jquery.peity.min.js"></script>
    <script src="/assets/vendor/apexchart/apexchart.js"></script>
    <script src="/assets/js/dashboard/dashboard-1.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/dlabnav-init.js"></script>
    
    <?= $additionalScripts ?? '' ?>
</body>
</html>

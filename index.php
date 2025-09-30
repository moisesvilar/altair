<?php

require_once 'autoload.php';

// Simular datos para el dashboard
$dashboardData = [
    'totalTenants' => 12,
    'activeUsers' => 143,
    'monthlyRevenue' => '25,890',
    'supportTickets' => 7,
    'recentTenants' => [
        [
            'name' => 'Empresa Demo',
            'domain' => 'demo.altair.com',
            'status' => 'Activo',
            'created_at' => date('d/m/Y')
        ],
        [
            'name' => 'Tech Solutions',
            'domain' => 'tech.altair.com',
            'status' => 'Pendiente',
            'created_at' => date('d/m/Y', strtotime('-1 day'))
        ]
    ]
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Altair - SaaS Admin Dashboard">
    <meta name="robots" content="index, follow">
    
    <title>Altair - SaaS Admin Dashboard</title>
    
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="public/assets/fillow/images/favicon.png">
    
    <!-- Vendor CSS -->
    <link href="public/assets/fillow/vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="public/assets/fillow/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/fillow/vendor/nouislider/nouislider.min.css">
    
    <!-- Main Style CSS -->
    <link href="public/assets/fillow/css/style.css" rel="stylesheet">
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
            <a href="index.php" class="brand-logo">
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
                                Dashboard
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <!-- Notifications -->
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.3333 19.8333H23.1187C23.2568 19.4597 23.3333 19.0597 23.3333 18.6458V14C23.3333 9.4791 20.1041 5.6666 15.75 4.9791V3.4999C15.75 2.5833 15.0833 1.8333 14.1666 1.8333C13.25 1.8333 12.5833 2.5833 12.5833 3.4999V4.9791C8.22913 5.6666 5 9.4791 5 14V18.6458C5 19.0597 5.07656 19.4597 5.21468 19.8333H5C4.08333 19.8333 3.33333 20.5833 3.33333 21.5C3.33333 22.4166 4.08333 23.1666 5 23.1666H23.3333C24.25 23.1666 25 22.4166 25 21.5C25 20.5833 24.25 19.8333 23.3333 19.8333Z" fill="#767676"/>
                                        <path d="M14.1667 26.8333C15.5833 26.8333 16.75 25.6666 16.75 24.25H11.5833C11.5833 25.6666 12.75 26.8333 14.1667 26.8333Z" fill="#767676"/>
                                    </svg>
                                    <span class="badge light text-white bg-primary rounded-circle">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="widget-timeline dz-scroll style-1 ps ps--active-y p-3 height370">
                                        <h6 class="mb-3">Notificaciones</h6>
                                        <div class="d-flex align-items-center p-3 border-bottom">
                                            <div class="notificaiton-icon me-3">
                                                <i class="fas fa-info-circle text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Bienvenido a Altair</h6>
                                                <p class="mb-0 fs-12">Tu dashboard está listo</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <!-- User Profile -->
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <img src="public/assets/fillow/images/profile/pic1.jpg" width="20" alt="user">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="#" class="dropdown-item ai-icon">
                                        <span class="ms-2">Perfil</span>
                                    </a>
                                    <a href="#" class="dropdown-item ai-icon">
                                        <span class="ms-2">Configuración</span>
                                    </a>
                                    <a href="#" class="dropdown-item ai-icon">
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
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <img src="public/assets/fillow/images/profile/pic1.jpg" width="20" alt="user">
                            <div class="header-info ms-3">
                                <span class="font-w600">Administrador</span>
                                <small class="text-end font-w400">admin@altair.com</small>
                            </div>
                        </a>
                    </li>
                    
                    <!-- Dashboard -->
                    <li class="mm-active">
                        <a href="index.php" aria-expanded="false">
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
                    
                    <!-- Analytics -->
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="flaticon-041-graph"></i>
                            <span class="nav-text">Analytics</span>
                        </a>
                    </li>
                    
                    <!-- Settings -->
                    <li>
                        <a href="#" aria-expanded="false">
                            <i class="flaticon-043-menu"></i>
                            <span class="nav-text">Configuración</span>
                        </a>
                    </li>
                </ul>
                
                <!-- Sidebar Footer -->
                <div class="copyright">
                    <p><strong>Altair SaaS Dashboard</strong> © <?php echo date('Y'); ?> Todos los derechos reservados</p>
                    <p class="fs-12">Hecho con <span class="heart"></span> por el equipo de Altair</p>
                </div>
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
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Total Tenants</div>
                                    <div class="stat-digit"><?php echo $dashboardData['totalTenants']; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fa fa-building text-success border-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Usuarios Activos</div>
                                    <div class="stat-digit"><?php echo $dashboardData['activeUsers']; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fa fa-users text-info border-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Ingresos Mensuales</div>
                                    <div class="stat-digit">$<?php echo $dashboardData['monthlyRevenue']; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fa fa-dollar-sign text-warning border-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-two card-body">
                                <div class="stat-content">
                                    <div class="stat-text">Soporte Tickets</div>
                                    <div class="stat-digit"><?php echo $dashboardData['supportTickets']; ?></div>
                                </div>
                                <div class="stat-icon">
                                    <i class="fa fa-ticket-alt text-danger border-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Actividad de Usuarios</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjs-bar" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Distribución de Tenants</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="chartjs-doughnut" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Últimos Tenants Registrados</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th style="width:80px;"><strong>#</strong></th>
                                                <th><strong>Nombre</strong></th>
                                                <th><strong>Dominio</strong></th>
                                                <th><strong>Estado</strong></th>
                                                <th><strong>Fecha</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($dashboardData['recentTenants'] as $index => $tenant): ?>
                                            <tr>
                                                <td><strong><?php echo $index + 1; ?></strong></td>
                                                <td><?php echo $tenant['name']; ?></td>
                                                <td><?php echo $tenant['domain']; ?></td>
                                                <td>
                                                    <span class="badge light badge-<?php echo $tenant['status'] === 'Activo' ? 'success' : 'warning'; ?>">
                                                        <i class="fa fa-circle text-<?php echo $tenant['status'] === 'Activo' ? 'success' : 'warning'; ?> me-1"></i>
                                                        <?php echo $tenant['status']; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $tenant['created_at']; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Actividad Reciente</h4>
                            </div>
                            <div class="card-body">
                                <div class="widget-timeline dz-scroll style-1 height370">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"></div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>Nuevo tenant registrado</span>
                                                <h6 class="mb-0">Tech Solutions se unió a la plataforma</h6>
                                                <small class="d-block">Hace 2 horas</small>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge info"></div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>Actualización completada</span>
                                                <h6 class="mb-0">Sistema actualizado a la versión 2.1.0</h6>
                                                <small class="d-block">Hace 5 horas</small>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="timeline-badge warning"></div>
                                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                                <span>Mantenimiento programado</span>
                                                <h6 class="mb-0">Mantenimiento de base de datos completado</h6>
                                                <small class="d-block">Ayer</small>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                <p>Copyright © Diseñado &amp; Desarrollado por <a href="#" target="_blank">Altair Team</a> <?php echo date('Y'); ?></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="public/assets/fillow/vendor/global/global.min.js"></script>
    <script src="public/assets/fillow/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="public/assets/fillow/vendor/chart-js/chart.bundle.min.js"></script>
    <script src="public/assets/fillow/vendor/owl-carousel/owl.carousel.js"></script>
    <script src="public/assets/fillow/vendor/peity/jquery.peity.min.js"></script>
    <script src="public/assets/fillow/vendor/apexchart/apexchart.js"></script>
    
    <!-- Dashboard 1 -->
    <script src="public/assets/fillow/js/dashboard/dashboard-1.js"></script>
    
    <!-- Main JS -->
    <script src="public/assets/fillow/js/custom.min.js"></script>
    <script src="public/assets/fillow/js/dlabnav-init.js"></script>
    
    <script>
        // Chart.js para el gráfico de barras
        const ctxBar = document.getElementById('chartjs-bar').getContext('2d');
        const chartBar = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Usuarios Activos',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(123, 102, 236, 0.8)',
                    borderColor: 'rgba(123, 102, 236, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart.js para el gráfico de dona
        const ctxDoughnut = document.getElementById('chartjs-doughnut').getContext('2d');
        const chartDoughnut = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Pendientes', 'Suspendidos'],
                datasets: [{
                    data: [75, 20, 5],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(220, 53, 69, 0.8)'
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>
</html>

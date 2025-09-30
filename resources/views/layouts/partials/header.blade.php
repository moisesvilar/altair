<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        @yield('page-title', 'Dashboard')
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
                            <div id="DZ_W_Notification1" class="widget-timeline dz-scroll style-1 ps ps--active-y p-3 height370">
                                <h6 class="mb-3">Notificaciones</h6>
                                <!-- Aquí irían las notificaciones dinámicas -->
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
                            <a class="all-notification" href="javascript:void(0);">Ver todas las notificaciones <i class="ti-arrow-end"></i></a>
                        </div>
                    </li>

                    <!-- User Profile -->
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <img src="{{ asset('assets/fillow/images/profile/pic1.jpg') }}" width="20" alt="user">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('profile') ?? '#' }}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ms-2">Perfil</span>
                            </a>
                            <a href="{{ route('settings') ?? '#' }}" class="dropdown-item ai-icon">
                                <svg id="icon-settings" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                <span class="ms-2">Configuración</span>
                            </a>
                            <form method="POST" action="{{ route('logout') ?? '#' }}">
                                @csrf
                                <button type="submit" class="dropdown-item ai-icon">
                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16,17 21,12 16,7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <span class="ms-2">Cerrar Sesión</span>
                                </button>
                            </form>
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

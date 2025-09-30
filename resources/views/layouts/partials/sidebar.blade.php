<!--**********************************
    Sidebar start
***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="{{ asset('assets/fillow/images/profile/pic1.jpg') }}" width="20" alt="user">
                    <div class="header-info ms-3">
                        <span class="font-w600">{{ auth()->user()->name ?? 'Usuario' }}</span>
                        <small class="text-end font-w400">{{ auth()->user()->email ?? 'usuario@ejemplo.com' }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('profile') ?? '#' }}" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Perfil</span>
                    </a>
                    <a href="{{ route('settings') ?? '#' }}" class="dropdown-item ai-icon">
                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox">
                            <polyline points="22,12 16,12 14,15 10,15 8,12 2,12"></polyline>
                            <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path>
                        </svg>
                        <span class="ms-2">Configuración</span>
                    </a>
                    <form method="POST" action="{{ route('logout') ?? '#' }}">
                        @csrf
                        <button type="submit" class="dropdown-item ai-icon">
                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16,17 21,12 16,7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span class="ms-2">Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </li>
            
            <!-- Dashboard -->
            <li class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('dashboard') ?? '/' }}" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <!-- Tenants Management -->
            <li class="{{ request()->routeIs('tenants.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-050-info"></i>
                    <span class="nav-text">Tenants</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('tenants.index') ?? '#' }}">Lista de Tenants</a></li>
                    <li><a href="{{ route('tenants.create') ?? '#' }}">Crear Tenant</a></li>
                </ul>
            </li>
            
            <!-- Users Management -->
            <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Usuarios</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('users.index') ?? '#' }}">Lista de Usuarios</a></li>
                    <li><a href="{{ route('users.create') ?? '#' }}">Crear Usuario</a></li>
                </ul>
            </li>
            
            <!-- Analytics -->
            <li class="{{ request()->routeIs('analytics.*') ? 'mm-active' : '' }}">
                <a href="{{ route('analytics.index') ?? '#' }}" aria-expanded="false">
                    <i class="flaticon-041-graph"></i>
                    <span class="nav-text">Analytics</span>
                </a>
            </li>
            
            <!-- Settings -->
            <li class="{{ request()->routeIs('settings.*') ? 'mm-active' : '' }}">
                <a href="{{ route('settings.index') ?? '#' }}" aria-expanded="false">
                    <i class="flaticon-043-menu"></i>
                    <span class="nav-text">Configuración</span>
                </a>
            </li>
        </ul>
        
        <!-- Sidebar Footer -->
        <div class="copyright">
            <p><strong>Altair SaaS Dashboard</strong> © {{ date('Y') }} Todos los derechos reservados</p>
            <p class="fs-12">Hecho con <span class="heart"></span> por el equipo de Altair</p>
        </div>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->

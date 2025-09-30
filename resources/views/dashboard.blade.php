@extends('layouts.app')

@section('title', 'Dashboard - Altair SaaS')

@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-two card-body">
                <div class="stat-content">
                    <div class="stat-text">Total Tenants</div>
                    <div class="stat-digit">{{ $totalTenants ?? '12' }}</div>
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
                    <div class="stat-digit">{{ $activeUsers ?? '143' }}</div>
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
                    <div class="stat-digit">${{ $monthlyRevenue ?? '25,890' }}</div>
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
                    <div class="stat-digit">{{ $supportTickets ?? '7' }}</div>
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
                            @forelse($recentTenants ?? [] as $tenant)
                            <tr>
                                <td><strong>{{ $loop->iteration }}</strong></td>
                                <td>{{ $tenant['name'] ?? 'Tenant Demo' }}</td>
                                <td>{{ $tenant['domain'] ?? 'demo.altair.com' }}</td>
                                <td>
                                    <span class="badge light badge-success">
                                        <i class="fa fa-circle text-success me-1"></i>
                                        {{ $tenant['status'] ?? 'Activo' }}
                                    </span>
                                </td>
                                <td>{{ $tenant['created_at'] ?? now()->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td><strong>1</strong></td>
                                <td>Empresa Demo</td>
                                <td>demo.altair.com</td>
                                <td>
                                    <span class="badge light badge-success">
                                        <i class="fa fa-circle text-success me-1"></i>
                                        Activo
                                    </span>
                                </td>
                                <td>{{ now()->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>2</strong></td>
                                <td>Tech Solutions</td>
                                <td>tech.altair.com</td>
                                <td>
                                    <span class="badge light badge-warning">
                                        <i class="fa fa-circle text-warning me-1"></i>
                                        Pendiente
                                    </span>
                                </td>
                                <td>{{ now()->subDay()->format('d/m/Y') }}</td>
                            </tr>
                            @endforelse
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
                                <small class="d-block">{{ now()->diffForHumans() }}</small>
                            </a>
                        </li>
                        <li>
                            <div class="timeline-badge info"></div>
                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                <span>Actualización completada</span>
                                <h6 class="mb-0">Sistema actualizado a la versión 2.1.0</h6>
                                <small class="d-block">{{ now()->subHours(2)->diffForHumans() }}</small>
                            </a>
                        </li>
                        <li>
                            <div class="timeline-badge warning"></div>
                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                <span>Mantenimiento programado</span>
                                <h6 class="mb-0">Mantenimiento de base de datos completado</h6>
                                <small class="d-block">{{ now()->subHours(5)->diffForHumans() }}</small>
                            </a>
                        </li>
                        <li>
                            <div class="timeline-badge success"></div>
                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                <span>Respaldo exitoso</span>
                                <h6 class="mb-0">Respaldo diario completado satisfactoriamente</h6>
                                <small class="d-block">{{ now()->subDay()->diffForHumans() }}</small>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection

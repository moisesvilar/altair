<div class="row">
    <div class="col-lg-3 col-sm-6">
        <div class="card">
            <div class="stat-widget-two card-body">
                <div class="stat-content">
                    <div class="stat-text">Total Tenants</div>
                    <div class="stat-digit"><?= $totalTenants ?? '12' ?></div>
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
                    <div class="stat-digit"><?= $activeUsers ?? '143' ?></div>
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
                    <div class="stat-digit">$<?= $monthlyRevenue ?? '25,890' ?></div>
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
                    <div class="stat-digit"><?= $supportTickets ?? '7' ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fa fa-ticket-alt text-danger border-danger"></i>
                </div>
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
                                <th><strong>#</strong></th>
                                <th><strong>Nombre</strong></th>
                                <th><strong>Estado</strong></th>
                                <th><strong>Fecha</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentTenants)): ?>
                                <?php foreach ($recentTenants as $index => $tenant): ?>
                                <tr>
                                    <td><strong><?= $index + 1 ?></strong></td>
                                    <td><?= htmlspecialchars($tenant['name']) ?></td>
                                    <td>
                                        <span class="badge light badge-<?= $tenant['status'] === 'Activo' ? 'success' : 'warning' ?>">
                                            <i class="fa fa-circle text-<?= $tenant['status'] === 'Activo' ? 'success' : 'warning' ?> me-1"></i>
                                            <?= htmlspecialchars($tenant['status']) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($tenant['created_at']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td><strong>1</strong></td>
                                <td>Empresa Demo</td>
                                <td>
                                    <span class="badge light badge-success">
                                        <i class="fa fa-circle text-success me-1"></i>
                                        Activo
                                    </span>
                                </td>
                                <td><?= date('d/m/Y') ?></td>
                            </tr>
                            <tr>
                                <td><strong>2</strong></td>
                                <td>Tech Solutions</td>
                                <td>
                                    <span class="badge light badge-warning">
                                        <i class="fa fa-circle text-warning me-1"></i>
                                        Pendiente
                                    </span>
                                </td>
                                <td><?= date('d/m/Y', strtotime('-1 day')) ?></td>
                            </tr>
                            <?php endif; ?>
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
                                <span>Usuario conectado</span>
                                <h6 class="mb-0"><?= htmlspecialchars($userName ?? 'Usuario') ?> inició sesión</h6>
                                <small class="d-block">Hace unos minutos</small>
                            </a>
                        </li>
                        <li>
                            <div class="timeline-badge info"></div>
                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                <span>Sistema iniciado</span>
                                <h6 class="mb-0">Dashboard cargado correctamente</h6>
                                <small class="d-block">Hace 2 horas</small>
                            </a>
                        </li>
                        <li>
                            <div class="timeline-badge success"></div>
                            <a class="timeline-panel text-muted" href="javascript:void(0);">
                                <span>Configuración actualizada</span>
                                <h6 class="mb-0">Sistema configurado con PHP puro</h6>
                                <small class="d-block">Hoy</small>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

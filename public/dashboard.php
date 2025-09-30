<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use Altair\Core\Session;
use Altair\Auth\Auth;
use Altair\Views\View;

Session::start();

// Debug logging
$debug_log = __DIR__ . '/../logs/debug.log';
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: Starting dashboard page\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: Auth::check() = " . (Auth::check() ? 'true' : 'false') . "\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: Auth::guest() = " . (Auth::guest() ? 'true' : 'false') . "\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: Session user data: " . json_encode(Session::get('user')) . "\n", FILE_APPEND | LOCK_EX);

// Check if user is authenticated
if (Auth::guest()) {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: User is guest, redirecting to login\n", FILE_APPEND | LOCK_EX);
    header('Location: login.php');
    exit;
} else {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] DASHBOARD DEBUG: User is authenticated, showing dashboard\n", FILE_APPEND | LOCK_EX);
}

// Get flash messages
$flashMessage = null;
$flashType = 'success';

if (Session::hasFlash('error')) {
    $flashMessage = Session::getFlash('error');
    $flashType = 'danger';
} elseif (Session::hasFlash('success')) {
    $flashMessage = Session::getFlash('success');
    $flashType = 'success';
}

// Sample data for dashboard
$dashboardData = [
    'totalTenants' => 12,
    'activeUsers' => 143,
    'monthlyRevenue' => '25,890',
    'supportTickets' => 7,
    'recentTenants' => [
        [
            'name' => 'Empresa Demo',
            'status' => 'Activo',
            'created_at' => date('d/m/Y')
        ],
        [
            'name' => 'Tech Solutions',
            'status' => 'Pendiente',
            'created_at' => date('d/m/Y', strtotime('-1 day'))
        ]
    ]
];

// Render dashboard
$view = new View(__DIR__ . '/../views/');

$content = $view->render('dashboard', $dashboardData);

echo $view->render('layouts.app', [
    'title' => 'Dashboard - Altair',
    'pageTitle' => 'Dashboard',
    'content' => $content,
    'userName' => Auth::name(),
    'userEmail' => Auth::email(),
    'flashMessage' => $flashMessage,
    'flashType' => $flashType
]);

<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use Altair\Core\Session;
use Altair\Auth\Auth;

Session::start();

// Debug logging
$debug_log = __DIR__ . '/../logs/debug.log';
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: Starting logout process\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: Auth::check() = " . (Auth::check() ? 'true' : 'false') . "\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: Session user data: " . json_encode(Session::get('user')) . "\n", FILE_APPEND | LOCK_EX);

// Check if user is authenticated before logout
if (Auth::check()) {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: User is authenticated, proceeding with logout\n", FILE_APPEND | LOCK_EX);
    
    // Logout user
    Auth::logout();
    
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: After logout, Auth::check() = " . (Auth::check() ? 'true' : 'false') . "\n", FILE_APPEND | LOCK_EX);
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: After logout, Session user data: " . json_encode(Session::get('user')) . "\n", FILE_APPEND | LOCK_EX);
    
    // Set flash message
    Session::flash('success', 'Has cerrado sesión correctamente.');
} else {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: User is not authenticated\n", FILE_APPEND | LOCK_EX);
}

file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGOUT DEBUG: Redirecting to login.php\n", FILE_APPEND | LOCK_EX);

// Redirect to login
header('Location: login.php');
exit;

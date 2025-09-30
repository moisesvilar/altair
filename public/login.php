<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use Altair\Core\Session;
use Altair\Auth\Auth;
use Altair\Views\View;

Session::start();

// Debug logging
$debug_log = __DIR__ . '/../logs/debug.log';
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGIN DEBUG: Starting login page\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGIN DEBUG: Auth::check() = " . (Auth::check() ? 'true' : 'false') . "\n", FILE_APPEND | LOCK_EX);
file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGIN DEBUG: Session user data: " . json_encode(Session::get('user')) . "\n", FILE_APPEND | LOCK_EX);

// Redirect if already authenticated
if (Auth::check()) {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGIN DEBUG: User is authenticated, redirecting to dashboard\n", FILE_APPEND | LOCK_EX);
    header('Location: dashboard.php');
    exit;
} else {
    file_put_contents($debug_log, "[" . date('Y-m-d H:i:s') . "] LOGIN DEBUG: User is not authenticated, showing login form\n", FILE_APPEND | LOCK_EX);
}

$errors = [];
$email = '';

// Handle POST request (login attempt)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Basic validation
    if (empty($email)) {
        $errors[] = 'El email es requerido.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'El email no es válido.';
    }
    
    if (empty($password)) {
        $errors[] = 'La contraseña es requerida.';
    }
    
    // Attempt authentication
    if (empty($errors)) {
        if (Auth::attempt($email, $password)) {
            // Successful login
            Session::flash('success', '¡Bienvenido de vuelta!');
            header('Location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Credenciales incorrectas.';
        }
    }
    
    // Store errors in session for display
    if (!empty($errors)) {
        Session::flash('error', implode('<br>', $errors));
    }
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

// Render login form
$view = new View(__DIR__ . '/../views/');

$content = $view->render('auth.login', [
    'email' => $email,
    'errors' => $errors
]);

echo $view->render('layouts.auth', [
    'title' => 'Iniciar Sesión - Altair',
    'content' => $content,
    'flashMessage' => $flashMessage,
    'flashType' => $flashType
]);

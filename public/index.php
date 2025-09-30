<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use Altair\Core\Session;
use Altair\Auth\Auth;

Session::start();

// Redirect based on authentication status
if (Auth::check()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}

exit;

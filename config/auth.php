<?php

return [
    'supabase' => [
        'url' => $_ENV['SUPABASE_AUTH_URL'] ?? $_ENV['SUPABASE_URL'] ?? '',
        'api_key' => $_ENV['SUPABASE_API_KEY'] ?? '',
        'service_role_key' => $_ENV['SUPABASE_SERVICE_ROLE_KEY'] ?? null,
    ],
    
    'session' => [
        'timeout' => 3600, // 1 hour in seconds
        'refresh_threshold' => 300, // Refresh token 5 minutes before expiry
    ],
    
    'security' => [
        'password_min_length' => 8,
        'require_email_verification' => true,
        'max_login_attempts' => 5,
        'lockout_duration' => 900, // 15 minutes in seconds
    ]
];

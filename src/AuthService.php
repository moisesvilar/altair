<?php

namespace MiProyecto;

use AuthLibrary\SupabaseAuth;
use Utils\EnvLoader;

class AuthService
{
    private static $instance = null;
    private $auth;
    private $config;

    private function __construct()
    {
        // Load environment variables
        EnvLoader::load();
        
        // Load auth configuration
        $this->config = require __DIR__ . '/../config/auth.php';
        
        // Create Supabase Auth instance
        $this->auth = new SupabaseAuth(
            EnvLoader::required('SUPABASE_AUTH_URL'),
            EnvLoader::required('SUPABASE_API_KEY')
        );
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getAuth(): SupabaseAuth
    {
        return $this->auth;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    // Convenience methods that delegate to SupabaseAuth
    public function signUp(string $email, string $password, array $metadata = []): array
    {
        return $this->auth->signUp($email, $password, $metadata);
    }

    public function signIn(string $email, string $password): array
    {
        return $this->auth->signIn($email, $password);
    }

    public function signOut(string $accessToken): bool
    {
        return $this->auth->signOut($accessToken);
    }

    public function getUser(string $accessToken): array
    {
        return $this->auth->getUser($accessToken);
    }

    public function refreshToken(string $refreshToken): array
    {
        return $this->auth->refreshToken($refreshToken);
    }

    public function resetPassword(string $email): bool
    {
        return $this->auth->resetPassword($email);
    }

    public function verify(string $token, string $type = 'signup'): array
    {
        return $this->auth->verify($token, $type);
    }

    // Additional utility methods
    public function isTokenExpired(array $tokenData): bool
    {
        if (!isset($tokenData['expires_at'])) {
            return true;
        }
        
        return time() >= $tokenData['expires_at'];
    }

    public function shouldRefreshToken(array $tokenData): bool
    {
        if (!isset($tokenData['expires_at'])) {
            return true;
        }
        
        $refreshThreshold = $this->config['session']['refresh_threshold'];
        return time() >= ($tokenData['expires_at'] - $refreshThreshold);
    }
}

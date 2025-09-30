<?php

declare(strict_types=1);

namespace Altair\Auth;

use Altair\Core\Session;
use Altair\AltairService;

final class Auth
{
    private static ?AltairService $altairService = null;

    private static function getAltairService(): AltairService
    {
        if (self::$altairService === null) {
            self::$altairService = new AltairService();
        }
        
        return self::$altairService;
    }

    public static function attempt(string $email, string $password): bool
    {
        try {
            $altairService = self::getAltairService();
            
            // Attempt to sign in using AltairService
            $authResult = $altairService->signIn($email, $password);
            
            // Extract user data from auth result
            $user = $authResult['user'] ?? null;
            
            if (!$user || !isset($user['id'])) {
                return false;
            }
            
            // Get additional user info from profile
            $userProfile = $altairService->getUserInfo($user['id']);
            
            // Store user in session with profile data
            Session::set('user', [
                'id' => $user['id'],
                'name' => $userProfile ? $userProfile->getFullName() : null,
                'email' => $user['email'],
                'role' => 'user', // Default role, can be extended based on tenant features
                'tenant_id' => $userProfile ? $userProfile->tenantId : null
            ]);

            return true;
            
        } catch (\Exception $e) {
            // Log error but don't expose internal details
            error_log("Auth attempt failed for {$email}: " . $e->getMessage());
            return false;
        }
    }

    public static function user(): ?array
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return Session::has('user');
    }

    public static function guest(): bool
    {
        return !self::check();
    }

    public static function logout(): void
    {
        Session::remove('user');
        
        // Also clear any flash messages that might interfere
        Session::remove('flash_success');
        Session::remove('flash_error');
        
        // Force session regeneration to prevent session fixation
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    public static function id(): ?int
    {
        $user = self::user();
        return $user['id'] ?? null;
    }

    public static function name(): ?string
    {
        $user = self::user();
        return $user['name'] ?? null;
    }

    public static function email(): ?string
    {
        $user = self::user();
        return $user['email'] ?? null;
    }

    public static function role(): ?string
    {
        $user = self::user();
        return $user['role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::role() === 'admin';
    }

    public static function tenantId(): ?int
    {
        $user = self::user();
        return $user['tenant_id'] ?? null;
    }

    public static function hasTenant(): bool
    {
        return self::tenantId() !== null;
    }
}

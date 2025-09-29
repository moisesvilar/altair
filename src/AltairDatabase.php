<?php

namespace Altair;

use Altair\AuthService;
use Altair\DatabaseService;
use Utils\Logger;

class AltairDatabase
{
    private AuthService $authService;
    private DatabaseService $databaseService;
    private ?string $currentUser = null;
    private ?array $userContext = null;
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger('AltairDatabase');
        
        try {
            // Initialize AuthService
            $this->authService = AuthService::getInstance();
            $this->logger->info('AuthService initialized successfully');
            
            // Initialize DatabaseService
            $this->databaseService = DatabaseService::getInstance();
            $this->logger->info('DatabaseService initialized successfully');
            
            $this->logger->info('AltairDatabase initialized successfully with Supabase connection');
            
        } catch (\Exception $e) {
            $this->logger->error('Error initializing AltairDatabase: ' . $e->getMessage());
            throw new \RuntimeException('Failed to initialize AltairDatabase: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Gets the authentication service instance
     */
    public function getAuthService(): AuthService
    {
        return $this->authService;
    }

    /**
     * Gets the database service instance
     */
    public function getDatabaseService(): DatabaseService
    {
        return $this->databaseService;
    }

    /**
     * Sets the current user context for authenticated operations
     */
    public function setUserContext(string $accessToken): void
    {
        try {
            $this->userContext = $this->authService->getUser($accessToken);
            $this->currentUser = $this->userContext['id'] ?? null;
            $this->logger->info('User context set for: ' . $this->currentUser);
        } catch (\Exception $e) {
            $this->logger->error('Error setting user context: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gets the current user ID
     */
    public function getCurrentUserId(): ?string
    {
        return $this->currentUser;
    }

    /**
     * Gets the complete current user context
     */
    public function getUserContext(): ?array
    {
        return $this->userContext;
    }

    /**
     * Clears the current user context
     */
    public function clearUserContext(): void
    {
        $this->currentUser = null;
        $this->userContext = null;
        $this->logger->info('User context cleared');
    }

    /**
     * Checks if there is an authenticated user
     */
    public function hasAuthenticatedUser(): bool
    {
        return $this->currentUser !== null;
    }
}

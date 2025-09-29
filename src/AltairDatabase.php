<?php

namespace Altair;

use Altair\AuthService;
use Altair\DatabaseService;
use Utils\Logger;

class AltairDatabase
{
    private AuthService $authService;
    private DatabaseService $databaseService;
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
     * Registers a user against Supabase
     *
     * @param string $email User's email
     * @param string $password User's password
     * @param array $metadata Additional metadata (optional)
     * @return AuthResult Supabase response with registered user data
     * @throws \Exception If an error occurs during registration
     */
    public function signUp(string $email, string $password, array $metadata = []): AuthResult
    {
        try {
            $this->logger->info("Attempting to sign up user with email: {$email}");
            
            $result = $this->authService->signUp($email, $password, $metadata);
            
            $this->logger->info("User signed up successfully: {$email}");
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error("Sign up failed for email {$email}: " . $e->getMessage());
            throw $e;
        }
    }
}

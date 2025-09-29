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
}

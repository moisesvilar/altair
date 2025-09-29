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

    /**
     * Set additional user information in the profiles table
     *
     * @param string $userId User's UUID from Supabase Auth
     * @param string|null $firstName User's first name (optional)
     * @param string|null $lastName User's last name (optional)
     * @param int|null $tenantId Tenant ID for multi-tenancy (optional)
     * @return UserProfile Created or updated user profile
     * @throws \Exception If an error occurs during the operation
     */
    public function setUserExtraInfo(
        string $userId,
        ?string $firstName = null,
        ?string $lastName = null,
        ?int $tenantId = null
    ): UserProfile {
        try {
            $this->logger->info("Setting extra info for user: {$userId}");
            
            // Prepare data for insertion/update
            $profileData = [
                'user_id' => $userId,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            if ($firstName !== null) {
                $profileData['first_name'] = $firstName;
            }
            
            if ($lastName !== null) {
                $profileData['last_name'] = $lastName;
            }
            
            if ($tenantId !== null) {
                $profileData['tenant_id'] = $tenantId;
            }
            
            // Check if profile exists
            $existingProfileQuery = "SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1";
            $existingProfile = $this->databaseService->query($existingProfileQuery, ['user_id' => $userId]);
            
            if (!empty($existingProfile)) {
                // Update existing profile
                $affectedRows = $this->databaseService->update('profiles', $profileData, ['user_id' => $userId]);
                
                $this->logger->info("Updated existing profile for user: {$userId}");
                
                // Get updated profile
                $updatedProfile = $this->databaseService->query($existingProfileQuery, ['user_id' => $userId]);
                
                return UserProfile::fromArray($updatedProfile[0]);
                
            } else {
                // Insert new profile
                $profileData['created_at'] = date('Y-m-d H:i:s');
                $profileData['is_active'] = true;
                
                $insertedId = $this->databaseService->insert('profiles', $profileData);
                
                $this->logger->info("Created new profile for user: {$userId} with ID: {$insertedId}");
                
                // Get created profile
                $newProfileQuery = "SELECT * FROM profiles WHERE id = :id LIMIT 1";
                $newProfile = $this->databaseService->query($newProfileQuery, ['id' => $insertedId]);
                
                return UserProfile::fromArray($newProfile[0]);
            }
            
        } catch (\Exception $e) {
            $this->logger->error("Failed to set extra info for user {$userId}: " . $e->getMessage());
            throw new \RuntimeException("Failed to set user extra info: " . $e->getMessage(), 0, $e);
        }
    }
}

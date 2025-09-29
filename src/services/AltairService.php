<?php

namespace Altair;

use Altair\AuthService;
use Altair\DatabaseService;
use Altair\Tenant;
use Utils\Logger;

class AltairService
{
    private AuthService $authService;
    private DatabaseService $databaseService;
    private Logger $logger;

    public function __construct()
    {
        $this->logger = new Logger(__DIR__ . '/../../logs/altair-service.log', true);
        
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
     * Sign in an existing user
     *
     * @param string $email User's email
     * @param string $password User's password
     * @return array Authentication result with user data and tokens
     * @throws \Exception If an error occurs during sign in
     */
    public function signIn(string $email, string $password): array
    {
        try {
            $this->logger->info("Attempting to sign in user with email: {$email}");
            
            $result = $this->authService->signIn($email, $password);
            
            $this->logger->info("User signed in successfully: {$email}");
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error("Sign in failed for email {$email}: " . $e->getMessage());
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

    /**
     * Get complete user information combining auth and profile data
     *
     * @param string $userId User's UUID from Supabase Auth
     * @return UserProfile|null Complete user profile with email or null if not found
     * @throws \Exception If an error occurs during the operation
     */
    public function getUserInfo(string $userId): ?UserProfile
    {
        try {
            $this->logger->info("Getting complete user info for user: {$userId}");
            
            // Get user data from Supabase Auth to obtain email
            $authUser = $this->authService->getUserById($userId);
            
            if (empty($authUser) || !isset($authUser['email'])) {
                $this->logger->warning("No auth user found for user ID: {$userId}");
                return null;
            }
            
            $email = $authUser['email'];
            
            // Get profile data from profiles table
            $profileQuery = "SELECT * FROM profiles WHERE user_id = :user_id LIMIT 1";
            $profileResult = $this->databaseService->query($profileQuery, ['user_id' => $userId]);
            
            if (empty($profileResult)) {
                $this->logger->info("No profile found for user: {$userId}, creating minimal profile with email");
                
                // Create a minimal profile structure if no profile exists in the database
                $minimalProfile = [
                    'id' => 0, // Temporary ID for non-existing profile
                    'user_id' => $userId,
                    'first_name' => null,
                    'last_name' => null,
                    'is_active' => true,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'tenant_id' => null,
                    'email' => $email
                ];
                
                return UserProfile::fromArray($minimalProfile);
            }
            
            // Create UserProfile with email from auth data
            $profileData = $profileResult[0];
            $profileData['email'] = $email; // Add email from auth to profile data
            
            $userProfile = UserProfile::fromArray($profileData);
            
            $this->logger->info("Complete user info retrieved successfully for user: {$userId}");
            
            return $userProfile;
            
        } catch (\Exception $e) {
            $this->logger->error("Failed to get user info for user {$userId}: " . $e->getMessage());
            throw new \RuntimeException("Failed to get user info: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Create a new tenant in the database
     *
     * @param string $name Tenant name (required)
     * @param string $createdBy User UUID who creates the tenant (required)
     * @return Tenant Created tenant data
     * @throws \Exception If an error occurs during tenant creation
     */
    public function createTenant(string $name, string $createdBy): Tenant
    {
        try {
            $this->logger->info("Creating new tenant with name: {$name} by user: {$createdBy}");
            
            // Generate slug automatically from name
            $slug = Tenant::generateSlug($name);
            
            // Check if slug already exists
            $existingTenantQuery = "SELECT id FROM tenants WHERE slug = :slug LIMIT 1";
            $existingTenant = $this->databaseService->query($existingTenantQuery, ['slug' => $slug]);
            
            if (!empty($existingTenant)) {
                throw new \RuntimeException("A tenant with slug '{$slug}' already exists");
            }
            
            // Prepare tenant data
            $currentTime = date('Y-m-d H:i:s');
            $tenantData = [
                'name' => $name,
                'slug' => $slug,
                'created_at' => $currentTime,
                'updated_at' => $currentTime,
                'created_by' => $createdBy
            ];
            
            // Insert new tenant
            $insertedId = $this->databaseService->insert('tenants', $tenantData);
            
            $this->logger->info("Created new tenant: {$name} with ID: {$insertedId} and slug: {$slug}");
            
            // Get created tenant
            $newTenantQuery = "SELECT * FROM tenants WHERE id = :id LIMIT 1";
            $newTenant = $this->databaseService->query($newTenantQuery, ['id' => $insertedId]);
            
            return Tenant::fromArray($newTenant[0]);
            
        } catch (\Exception $e) {
            $this->logger->error("Failed to create tenant '{$name}': " . $e->getMessage());
            throw new \RuntimeException("Failed to create tenant: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get tenant data by ID
     *
     * @param int $tenantId Tenant ID
     * @return Tenant|null Tenant data or null if not found
     * @throws \Exception If an error occurs during the operation
     */
    public function getTenantById(int $tenantId): ?Tenant
    {
        try {
            $this->logger->info("Getting tenant data for ID: {$tenantId}");
            
            $tenantQuery = "SELECT * FROM tenants WHERE id = :id LIMIT 1";
            $tenantResult = $this->databaseService->query($tenantQuery, ['id' => $tenantId]);
            
            if (empty($tenantResult)) {
                $this->logger->warning("No tenant found with ID: {$tenantId}");
                return null;
            }
            
            $tenant = Tenant::fromArray($tenantResult[0]);
            
            $this->logger->info("Tenant data retrieved successfully for ID: {$tenantId}");
            
            return $tenant;
            
        } catch (\Exception $e) {
            $this->logger->error("Failed to get tenant with ID {$tenantId}: " . $e->getMessage());
            throw new \RuntimeException("Failed to get tenant: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Update tenant name and automatically regenerate slug
     *
     * @param int $tenantId Tenant ID to update
     * @param string $newName New tenant name
     * @return Tenant Updated tenant data
     * @throws \Exception If an error occurs during the operation
     */
    public function updateTenant(int $tenantId, string $newName): Tenant
    {
        try {
            $this->logger->info("Updating tenant with ID: {$tenantId} to name: {$newName}");
            
            // Check if tenant exists
            $existingTenant = $this->getTenantById($tenantId);
            if ($existingTenant === null) {
                throw new \RuntimeException("Tenant with ID {$tenantId} not found");
            }
            
            // Generate new slug from new name
            $newSlug = Tenant::generateSlug($newName);
            
            // Check if the new slug conflicts with another tenant (excluding current one)
            $conflictQuery = "SELECT id FROM tenants WHERE slug = :slug AND id != :id LIMIT 1";
            $conflictResult = $this->databaseService->query($conflictQuery, [
                'slug' => $newSlug,
                'id' => $tenantId
            ]);
            
            if (!empty($conflictResult)) {
                throw new \RuntimeException("A tenant with slug '{$newSlug}' already exists");
            }
            
            // Prepare update data
            $updateData = [
                'name' => $newName,
                'slug' => $newSlug,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            // Update tenant
            $affectedRows = $this->databaseService->update('tenants', $updateData, ['id' => $tenantId]);
            
            if ($affectedRows === 0) {
                throw new \RuntimeException("No rows were updated. Tenant might not exist or data is identical.");
            }
            
            $this->logger->info("Tenant updated successfully: ID {$tenantId}, new name: {$newName}, new slug: {$newSlug}");
            
            // Get updated tenant data
            $updatedTenant = $this->getTenantById($tenantId);
            
            if ($updatedTenant === null) {
                throw new \RuntimeException("Failed to retrieve updated tenant data");
            }
            
            return $updatedTenant;
            
        } catch (\Exception $e) {
            $this->logger->error("Failed to update tenant {$tenantId}: " . $e->getMessage());
            throw new \RuntimeException("Failed to update tenant: " . $e->getMessage(), 0, $e);
        }
    }
}

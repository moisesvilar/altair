<?php

require_once __DIR__ . '/../autoload.php';

use Altair\AltairService;
use Utils\Logger;

// Initialize logger
$logger = new Logger(__DIR__ . '/../logs/user-workflow-test.log', true);

try {
    $logger->info("=== Starting User Workflow Test ===");
    echo "=== User Workflow Test Script ===\n\n";
    
    // Initialize AltairService
    $altairService = new AltairService();
    echo "✓ AltairService initialized successfully\n\n";
    
    // Test credentials
    $testEmail = 'dkholin0@gmail.com';
    $testPassword = '11841983';
    
    // Step 1: Sign In
    echo "=== Step 1: Sign In ===\n";
    echo "Attempting to sign in with email: {$testEmail}\n";
    
    try {
        $signInResult = $altairService->signIn($testEmail, $testPassword);
        
        if (isset($signInResult['user']['id'])) {
            $userId = $signInResult['user']['id'];
            echo "✓ Sign in successful!\n";
            echo "User ID: {$userId}\n";
            echo "Email: " . ($signInResult['user']['email'] ?? 'N/A') . "\n";
            $logger->info("Sign in successful for user: {$testEmail}", ['user_id' => $userId]);
        } else {
            throw new \Exception("Sign in response missing user ID");
        }
        
    } catch (\Exception $e) {
        echo "✗ Sign in failed: " . $e->getMessage() . "\n";
        $logger->error("Sign in failed: " . $e->getMessage());
        exit(1);
    }
    
    echo "\n";
    
    // Step 2: Add Extra Information
    echo "=== Step 2: Add User Extra Information ===\n";
    echo "Adding first name: Dalinar\n";
    echo "Adding last name: Kholin\n";
    
    try {
        $profile = $altairService->setUserExtraInfo(
            userId: $userId,
            firstName: 'Dalinar',
            lastName: 'Kholin'
        );
        
        echo "✓ User extra information added successfully!\n";
        echo "Profile ID: {$profile->id}\n";
        echo "Full Name: " . $profile->getFullName() . "\n";
        $logger->info("User extra info set successfully", [
            'user_id' => $userId,
            'profile_id' => $profile->id,
            'first_name' => 'Dalinar',
            'last_name' => 'Kholin'
        ]);
        
    } catch (\Exception $e) {
        echo "✗ Failed to add extra information: " . $e->getMessage() . "\n";
        $logger->error("Failed to set user extra info: " . $e->getMessage());
        exit(1);
    }
    
    echo "\n";
    
    // Step 3: Get User Information (first time)
    echo "=== Step 3: Get Complete User Information ===\n";
    
    try {
        $userInfo = $altairService->getUserInfo($userId);
        
        if ($userInfo) {
            echo "✓ User information retrieved successfully!\n";
            echo "User ID: {$userInfo->userId}\n";
            echo "Email: {$userInfo->email}\n";
            echo "First Name: " . ($userInfo->firstName ?? 'Not set') . "\n";
            echo "Last Name: " . ($userInfo->lastName ?? 'Not set') . "\n";
            
            $logger->info("User info retrieved successfully", [
                'user_id' => $userInfo->userId,
                'email' => $userInfo->email,
                'first_name' => $userInfo->firstName,
                'last_name' => $userInfo->lastName
            ]);
        } else {
            echo "✗ No user information found\n";
            exit(1);
        }
        
    } catch (\Exception $e) {
        echo "✗ Failed to get user information: " . $e->getMessage() . "\n";
        $logger->error("Failed to get user info: " . $e->getMessage());
        exit(1);
    }
    
    echo "\n";
    
    // Step 4: Update Tenant ID
    echo "=== Step 4: Update Tenant ID ===\n";
    echo "Setting tenant ID to: 1\n";
    
    try {
        $updatedProfile = $altairService->setUserExtraInfo(
            userId: $userId,
            tenantId: 1
        );
        
        echo "✓ Tenant ID updated successfully!\n";
        echo "New Tenant ID: " . ($updatedProfile->tenantId ?? 'Not set') . "\n";
        $logger->info("Tenant ID updated successfully", [
            'user_id' => $userId,
            'tenant_id' => 1
        ]);
        
    } catch (\Exception $e) {
        echo "✗ Failed to update tenant ID: " . $e->getMessage() . "\n";
        $logger->error("Failed to update tenant ID: " . $e->getMessage());
        exit(1);
    }
    
    echo "\n";
    
    // Step 5: Get Complete User Information (final)
    echo "=== Step 5: Get Final Complete User Information ===\n";
    
    try {
        $finalUserInfo = $altairService->getUserInfo($userId);
        
        if ($finalUserInfo) {
            echo "✓ Final user information retrieved successfully!\n";
            echo "User ID: {$finalUserInfo->userId}\n";
            echo "Email: {$finalUserInfo->email}\n";
            echo "First Name: " . ($finalUserInfo->firstName ?? 'Not set') . "\n";
            echo "Last Name: " . ($finalUserInfo->lastName ?? 'Not set') . "\n";
            echo "Tenant ID: " . ($finalUserInfo->tenantId ?? 'Not set') . "\n";
            echo "Full Name: " . ($finalUserInfo->getFullName() ?? 'Not available') . "\n";
            echo "Is Active: " . ($finalUserInfo->isActive ? 'Yes' : 'No') . "\n";
            echo "Profile ID: {$finalUserInfo->id}\n";
            echo "Created At: {$finalUserInfo->createdAt}\n";
            echo "Updated At: {$finalUserInfo->updatedAt}\n";
            
            $logger->info("Final user info retrieved successfully", [
                'user_id' => $finalUserInfo->userId,
                'email' => $finalUserInfo->email,
                'first_name' => $finalUserInfo->firstName,
                'last_name' => $finalUserInfo->lastName,
                'tenant_id' => $finalUserInfo->tenantId,
                'full_name' => $finalUserInfo->getFullName(),
                'is_active' => $finalUserInfo->isActive,
                'profile_id' => $finalUserInfo->id
            ]);
        } else {
            echo "✗ No final user information found\n";
            exit(1);
        }
        
    } catch (\Exception $e) {
        echo "✗ Failed to get final user information: " . $e->getMessage() . "\n";
        $logger->error("Failed to get final user info: " . $e->getMessage());
        exit(1);
    }
    
    echo "\n";
    
    // Summary
    echo "=== Test Summary ===\n";
    echo "✓ All steps completed successfully!\n";
    echo "\nCompleted operations:\n";
    echo "1. ✓ Signed in with user: {$testEmail}\n";
    echo "2. ✓ Added first name: Dalinar\n";
    echo "3. ✓ Added last name: Kholin\n";
    echo "4. ✓ Retrieved user information with name\n";
    echo "5. ✓ Updated tenant ID to: 1\n";
    echo "6. ✓ Retrieved complete user information with tenant\n";
    
    echo "\nFinal user data:\n";
    echo "- User ID: {$finalUserInfo->userId}\n";
    echo "- Email: {$finalUserInfo->email}\n";
    echo "- Name: {$finalUserInfo->getFullName()}\n";
    echo "- Tenant: {$finalUserInfo->tenantId}\n";
    echo "- Status: " . ($finalUserInfo->isActive ? 'Active' : 'Inactive') . "\n";
    
    $logger->info("=== User Workflow Test Completed Successfully ===");
    echo "\n✓ Test completed! Check logs/user-workflow-test.log for detailed information.\n";
    
} catch (\Exception $e) {
    $logger->error("Fatal error in workflow test: " . $e->getMessage());
    echo "\n✗ Fatal error: " . $e->getMessage() . "\n";
    echo "Check logs/user-workflow-test.log for more details.\n";
    exit(1);
}

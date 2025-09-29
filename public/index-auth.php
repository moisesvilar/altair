<?php

require_once __DIR__ . '/../autoload.php';

use AuthLibrary\SupabaseAuth;
use Utils\EnvLoader;
use Utils\Logger;

// Initialize logger
$logger = new Logger(__DIR__ . '/../logs/auth.log', true);

try {
    $logger->info("=== Starting Supabase Auth Test ===");
    
    // Load environment variables
    EnvLoader::load();
    $logger->info("Environment variables loaded");
    
    // Get required configuration
    try {
        $supabaseUrl = EnvLoader::required('SUPABASE_AUTH_URL');
        $apiKey = EnvLoader::required('SUPABASE_API_KEY');
        $logger->info("Configuration loaded successfully");
    } catch (\RuntimeException $e) {
        $logger->error("Missing required environment variables: " . $e->getMessage());
        echo "Error: Missing required environment variables\n";
        echo "Please create a .env file with SUPABASE_AUTH_URL and SUPABASE_API_KEY\n";
        echo "You can copy from env.example and update the values\n";
        exit(1);
    }
    
    // Create SupabaseAuth instance
    $auth = new SupabaseAuth($supabaseUrl, $apiKey);
    $logger->info("SupabaseAuth instance created");
    echo "SupabaseAuth initialized successfully\n";
    
    // Test email for demo (using simple format)
    $testEmail = 'user' . rand(100, 999) . '@test.com';
    $testEmail = 'dkholin0@gmail.com';
    $testPassword = 'TestPassword123!';
    
    echo "\n=== Testing User Registration ===\n";
    $logger->info("Testing user registration with email: " . $testEmail);
    
    try {
        $signUpResult = $auth->signUp($testEmail, $testPassword, [
            'name' => 'Test User',
            'role' => 'user'
        ]);
        
        $logger->info("User registration successful", $signUpResult->toArray());
        echo "User registered successfully\n";
        echo "User ID: " . $signUpResult->id . "\n";
        echo "Email: " . $signUpResult->email . "\n";
        
        // Store access token for further tests
        $accessToken = $signUpResult->accessToken;
        $refreshToken = $signUpResult->refreshToken;
        
        if ($accessToken) {
            echo "\n=== Testing Get User Info ===\n";
            $logger->info("Testing get user info");
            
            try {
                $userInfo = $auth->getUser($accessToken);
                $logger->info("Get user info successful", $userInfo);
                echo "User info retrieved successfully\n";
                echo "User: " . ($userInfo['email'] ?? 'N/A') . "\n";
                echo "Confirmed: " . ($userInfo['email_confirmed_at'] ? 'Yes' : 'No') . "\n";
            } catch (\Exception $e) {
                $logger->error("Get user info failed: " . $e->getMessage());
                echo "Get user info failed: " . $e->getMessage() . "\n";
            }
            
            if ($refreshToken) {
                echo "\n=== Testing Token Refresh ===\n";
                $logger->info("Testing token refresh");
                
                try {
                    $refreshResult = $auth->refreshToken($refreshToken);
                    $logger->info("Token refresh successful", $refreshResult);
                    echo "Token refreshed successfully\n";
                    echo "New access token received\n";
                    
                    // Update access token for logout test
                    $accessToken = $refreshResult['access_token'] ?? $accessToken;
                } catch (\Exception $e) {
                    $logger->error("Token refresh failed: " . $e->getMessage());
                    echo "Token refresh failed: " . $e->getMessage() . "\n";
                }
            }
            
            echo "\n=== Testing Sign Out ===\n";
            $logger->info("Testing sign out");
            
            $signOutResult = $auth->signOut($accessToken);
            if ($signOutResult) {
                $logger->info("Sign out successful");
                echo "User signed out successfully\n";
            } else {
                $logger->warning("Sign out failed or token was already invalid");
                echo "Sign out failed (token might be invalid)\n";
            }
        }
        
    } catch (\Exception $e) {
        $logger->error("User registration failed: " . $e->getMessage());
        echo "User registration failed: " . $e->getMessage() . "\n";
        
        // If registration failed, try sign in with existing credentials
        echo "\n=== Testing Sign In (with demo credentials) ===\n";
        $logger->info("Testing sign in");
        
        try {
            $signInResult = $auth->signIn('demo@example.com', 'demo123');
            $logger->info("Sign in successful", $signInResult);
            echo "Sign in successful\n";
            echo "Welcome back: " . ($signInResult['user']['email'] ?? 'N/A') . "\n";
        } catch (\Exception $e) {
            $logger->error("Sign in failed: " . $e->getMessage());
            echo "Sign in failed: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n=== Testing Password Reset ===\n";
    $logger->info("Testing password reset");
    
    // Try with redirect URL (required by some Supabase configurations)
    $redirectUrl = 'http://localhost:3000/reset-password';
    $resetResult = $auth->resetPassword($testEmail, $redirectUrl);
    if ($resetResult) {
        $logger->info("Password reset email sent successfully");
        echo "Password reset email sent successfully\n";
    } else {
        $logger->warning("Password reset failed");
    }
    
    echo "\n=== Testing Token Verification ===\n";
    $logger->info("Testing token verification");
    
    try {
        // This will likely fail since we don't have a real verification token
        $verifyResult = $auth->verify('dummy-token', 'signup');
        $logger->info("Token verification successful", $verifyResult);
        echo "Token verification successful\n";
    } catch (\Exception $e) {
        $logger->error("Token verification failed (expected with dummy token): " . $e->getMessage());
        echo "Token verification failed (expected - dummy token used for testing)\n";
    }
    
    $logger->info("=== Auth Test Completed ===");
    echo "\nAll tests completed! Check logs/auth.log for detailed information.\n";
    
} catch (\Exception $e) {
    $logger->error("Fatal error: " . $e->getMessage());
    echo "Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}

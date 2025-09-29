<?php

namespace AuthLibrary;

interface Auth
{
    /**
     * Register a new user with email and password
     *
     * @param string $email User's email address
     * @param string $password User's password
     * @param array $metadata Additional user metadata (optional)
     * @return array User data and authentication tokens
     */
    public function signUp(string $email, string $password, array $metadata = []): array;

    /**
     * Sign in an existing user
     *
     * @param string $email User's email address
     * @param string $password User's password
     * @return array User data and authentication tokens
     */
    public function signIn(string $email, string $password): array;

    /**
     * Sign out a user by invalidating their access token
     *
     * @param string $accessToken User's access token
     * @return bool Success status
     */
    public function signOut(string $accessToken): bool;

    /**
     * Get user information from access token
     *
     * @param string $accessToken User's access token
     * @return array User data
     */
    public function getUser(string $accessToken): array;

    /**
     * Refresh an expired access token using refresh token
     *
     * @param string $refreshToken User's refresh token
     * @return array New access token and refresh token
     */
    public function refreshToken(string $refreshToken): array;

    /**
     * Send password reset email to user
     *
     * @param string $email User's email address
     * @param string|null $redirectTo Optional redirect URL after password reset
     * @return bool Success status
     */
    public function resetPassword(string $email, ?string $redirectTo = null): bool;

    /**
     * Verify user account or password reset token
     *
     * @param string $token Verification token
     * @param string $type Type of verification ('signup', 'recovery', etc.)
     * @return array Verification result
     */
    public function verify(string $token, string $type = 'signup'): array;
}

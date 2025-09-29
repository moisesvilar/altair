<?php

declare(strict_types=1);

namespace Altair;

final class AuthResult
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly ?string $emailConfirmedAt,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $accessToken,
        public readonly string $refreshToken,
        public readonly int $expiresIn,
        public readonly int $expiresAt,
        public readonly string $tokenType,
        public readonly array $userMetadata,
        public readonly array $appMetadata,
        public readonly string $aud,
        public readonly string $role,
        public readonly ?string $confirmationSentAt
    ) {}

    /**
     * Create AuthResult instance from Supabase API response
     *
     * @param array $data Raw response data from Supabase
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            email: $data['email'] ?? '',
            emailConfirmedAt: $data['email_confirmed_at'] ?? null,
            createdAt: $data['created_at'] ?? '',
            updatedAt: $data['updated_at'] ?? '',
            accessToken: $data['access_token'] ?? '',
            refreshToken: $data['refresh_token'] ?? '',
            expiresIn: $data['expires_in'] ?? 0,
            expiresAt: $data['expires_at'] ?? 0,
            tokenType: $data['token_type'] ?? 'bearer',
            userMetadata: $data['user_metadata'] ?? [],
            appMetadata: $data['app_metadata'] ?? [],
            aud: $data['aud'] ?? 'authenticated',
            role: $data['role'] ?? 'authenticated',
            confirmationSentAt: $data['confirmation_sent_at'] ?? null
        );
    }

    /**
     * Convert AuthResult to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'email_confirmed_at' => $this->emailConfirmedAt,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'expires_in' => $this->expiresIn,
            'expires_at' => $this->expiresAt,
            'token_type' => $this->tokenType,
            'user_metadata' => $this->userMetadata,
            'app_metadata' => $this->appMetadata,
            'aud' => $this->aud,
            'role' => $this->role,
            'confirmation_sent_at' => $this->confirmationSentAt
        ];
    }

    /**
     * Check if the token is expired
     *
     * @return bool
     */
    public function isTokenExpired(): bool
    {
        return time() >= $this->expiresAt;
    }

    /**
     * Check if the token should be refreshed based on threshold
     *
     * @param int $refreshThreshold Threshold in seconds before expiration
     * @return bool
     */
    public function shouldRefreshToken(int $refreshThreshold = 300): bool
    {
        return time() >= ($this->expiresAt - $refreshThreshold);
    }
}

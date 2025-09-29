<?php

declare(strict_types=1);

namespace Altair;

final class UserProfile
{
    public function __construct(
        public readonly int $id,
        public readonly string $userId,
        public readonly ?string $firstName,
        public readonly ?string $lastName,
        public readonly bool $isActive,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly ?int $tenantId
    ) {}

    /**
     * Create UserProfile instance from database row
     *
     * @param array $data Raw database row data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            userId: (string) $data['user_id'],
            firstName: $data['first_name'] ?? null,
            lastName: $data['last_name'] ?? null,
            isActive: (bool) ($data['is_active'] ?? true),
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
            tenantId: isset($data['tenant_id']) ? (int) $data['tenant_id'] : null
        );
    }

    /**
     * Convert UserProfile to array for database operations
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'is_active' => $this->isActive,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'tenant_id' => $this->tenantId
        ];
    }

    /**
     * Get full name combining first and last name
     *
     * @return string|null
     */
    public function getFullName(): ?string
    {
        if (!$this->firstName && !$this->lastName) {
            return null;
        }
        
        return trim(($this->firstName ?? '') . ' ' . ($this->lastName ?? ''));
    }

    /**
     * Check if profile has complete name information
     *
     * @return bool
     */
    public function hasCompleteName(): bool
    {
        return !empty($this->firstName) && !empty($this->lastName);
    }
}

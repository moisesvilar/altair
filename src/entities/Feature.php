<?php

declare(strict_types=1);

namespace Altair;

final class Feature
{
    public function __construct(
        public readonly int $id,
        public readonly int $tenantId,
        public readonly string $ref,
        public readonly ?string $expirationDate
    ) {}

    /**
     * Create Feature instance from database row
     *
     * @param array $data Raw database row data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            tenantId: (int) $data['tenant_id'] ?? (int) $data['tenant'],
            ref: (string) $data['ref'] ?? (string) $data['feature'],
            expirationDate: $data['expiration_date'] ?? null
        );
    }

    /**
     * Check if the feature is expired for the tenant
     *
     * @return bool True if the feature is expired, false otherwise
     */
    public function isExpired(): bool
    {
        // If no expiration date is set, the feature never expires
        if ($this->expirationDate === null) {
            return false;
        }

        try {
            $expirationDateTime = new \DateTime($this->expirationDate);
            $currentDateTime = new \DateTime();
            
            return $currentDateTime > $expirationDateTime;
        } catch (\Exception $e) {
            // If we can't parse the date, consider it not expired to be safe
            return false;
        }
    }

    /**
     * Check if the feature is active (not expired)
     *
     * @return bool True if the feature is active, false if expired
     */
    public function isActive(): bool
    {
        return !$this->isExpired();
    }

    /**
     * Get formatted expiration date
     *
     * @param string $format Date format (default: 'Y-m-d H:i:s')
     * @return string|null Formatted date or null if no expiration date
     */
    public function getFormattedExpirationDate(string $format = 'Y-m-d H:i:s'): ?string
    {
        if ($this->expirationDate === null) {
            return null;
        }

        try {
            $dateTime = new \DateTime($this->expirationDate);
            return $dateTime->format($format);
        } catch (\Exception $e) {
            return $this->expirationDate; // Return raw value if parsing fails
        }
    }

    /**
     * Get days until expiration
     *
     * @return int|null Number of days until expiration, null if no expiration date, negative if already expired
     */
    public function getDaysUntilExpiration(): ?int
    {
        if ($this->expirationDate === null) {
            return null;
        }

        try {
            $expirationDateTime = new \DateTime($this->expirationDate);
            $currentDateTime = new \DateTime();
            
            $interval = $currentDateTime->diff($expirationDateTime);
            $days = (int) $interval->format('%r%a'); // %r gives sign, %a gives absolute days
            
            return $days;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get feature status as string
     *
     * @return string 'active', 'expired', or 'permanent'
     */
    public function getStatus(): string
    {
        if ($this->expirationDate === null) {
            return 'permanent';
        }

        return $this->isExpired() ? 'expired' : 'active';
    }

    /**
     * Convert to array representation
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenantId,
            'ref' => $this->ref,
            'expiration_date' => $this->expirationDate,
            'is_expired' => $this->isExpired(),
            'is_active' => $this->isActive(),
            'status' => $this->getStatus(),
            'days_until_expiration' => $this->getDaysUntilExpiration()
        ];
    }

    /**
     * Convert to JSON string
     *
     * @return string JSON representation
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}

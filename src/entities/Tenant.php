<?php

declare(strict_types=1);

namespace Altair;

final class Tenant
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $createdAt,
        public readonly string $updatedAt,
        public readonly string $createdBy
    ) {}

    /**
     * Create Tenant instance from database row
     *
     * @param array $data Raw database row data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: (string) $data['name'],
            slug: (string) $data['slug'],
            createdAt: (string) $data['created_at'],
            updatedAt: (string) $data['updated_at'],
            createdBy: (string) $data['created_by']
        );
    }

    /**
     * Convert Tenant to array for database operations
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
            'created_by' => $this->createdBy
        ];
    }

    /**
     * Generate a URL-friendly slug from a string
     *
     * @param string $text Input text to convert to slug
     * @return string URL-friendly slug
     */
    public static function generateSlug(string $text): string
    {
        // Convert to lowercase
        $slug = strtolower($text);
        
        // Replace spaces and special characters with hyphens
        $slug = preg_replace('/[^a-z0-9\-]/', '-', $slug);
        
        // Remove multiple consecutive hyphens
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Remove leading and trailing hyphens
        $slug = trim($slug, '-');
        
        return $slug;
    }
}

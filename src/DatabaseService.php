<?php

namespace MiProyecto;

use DatabaseLibrary\DatabaseManager;
use Utils\EnvLoader;

class DatabaseService
{
    private static $instance = null;
    private $db;

    private function __construct()
    {
        // Load environment variables
        EnvLoader::load();

        // Create database connection
        $this->db = DatabaseManager::createSupabaseFromUrl(
            EnvLoader::required('SUPABASE_URL'),
            EnvLoader::required('SUPABASE_PASSWORD')
        );

        $this->db->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDatabase(): DatabaseManager
    {
        return $this->db;
    }

    public function query(string $sql, array $params = []): array
    {
        return $this->db->executeQuery($sql, $params);
    }

    public function insert(string $table, array $data): int
    {
        $queryBuilder = $this->db->queryBuilder($table);
        $query = $queryBuilder->buildInsert($data);
        return $this->db->executeInsert($query, $queryBuilder->getParams());
    }

    public function update(string $table, array $data, array $conditions): int
    {
        $queryBuilder = $this->db->queryBuilder($table);

        foreach ($conditions as $column => $value) {
            $queryBuilder->where($column, '=', $value);
        }

        $query = $queryBuilder->buildUpdate($data);
        return $this->db->executeUpdate($query, $queryBuilder->getParams());
    }

    public function transaction(callable $callback)
    {
        $this->db->beginTransaction();

        try {
            $result = $callback($this->db);
            $this->db->commit();
            return $result;
        } catch (\Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    public function __destruct()
    {
        if ($this->db && $this->db->isConnected()) {
            $this->db->disconnect();
        }
    }
}

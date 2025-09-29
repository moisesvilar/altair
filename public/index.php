<?php

require_once '../autoload.php';

use Altair\DatabaseService;

try {
    // Get database service
    $dbService = DatabaseService::getInstance();

    // Example: Create users table
    $dbService->query("
        CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    echo "✓ Table created/verified\\n";

    // Example: Insert user
    $userId = $dbService->insert('users', [
        'name' => 'John Doe',
        'email' => 'john_' . time() . '@example.com'
    ]);

    echo "✓ User created with ID: {$userId}\\n";

    // Example: Query users
    $users = $dbService->query('SELECT * FROM users ORDER BY created_at DESC LIMIT 5');

    echo "✓ Users found: " . count($users) . "\\n";
    foreach ($users as $user) {
        echo "  - {$user['name']} ({$user['email']})\\n";
    }

    // Example: Transaction
    $result = $dbService->transaction(function($db) {
        $queryBuilder = $db->queryBuilder('users');

        $query = $queryBuilder->buildInsert([
            'name' => 'Mary Garcia',
            'email' => 'mary_' . time() . '@example.com'
        ]);
        $db->executeInsert($query, $queryBuilder->getParams());

        return 'Transaction completed';
    });

    echo "✓ {$result}\\n";

} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\\n";
}

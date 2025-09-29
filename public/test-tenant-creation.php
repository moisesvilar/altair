<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

use Altair\AltairService;

echo "=== PRUEBA DE CREACIÓN DE TENANT ===\n\n";

try {
    // Initialize AltairService
    echo "1. Inicializando AltairService...\n";
    $altairService = new AltairService();
    echo "✓ AltairService inicializado correctamente\n\n";

    // Sign in with specified credentials
    echo "2. Iniciando sesión...\n";
    $email = 'dkholin0@gmail.com';
    $password = '11841983';
    
    echo "   Email: {$email}\n";
    echo "   Intentando iniciar sesión...\n";
    
    $signInResult = $altairService->signIn($email, $password);
    
    if (empty($signInResult) || !isset($signInResult['user']['id'])) {
        throw new \Exception('Error en el inicio de sesión: No se obtuvo el ID de usuario');
    }
    
    $userId = $signInResult['user']['id'];
    echo "✓ Inicio de sesión exitoso\n";
    echo "   User ID: {$userId}\n";
    echo "   Email: {$signInResult['user']['email']}\n\n";

    // Create tenant
    echo "3. Creando tenant...\n";
    $tenantName = 'Honor está muerto';
    echo "   Nombre del tenant: {$tenantName}\n";
    echo "   Creado por: {$userId}\n";
    
    $tenant = $altairService->createTenant($tenantName, $userId);
    
    echo "✓ Tenant creado exitosamente\n\n";

    // Display tenant data
    echo "4. DATOS DEL TENANT CREADO:\n";
    echo "========================================\n";
    echo "ID: {$tenant->id}\n";
    echo "Nombre: {$tenant->name}\n";
    echo "Slug: {$tenant->slug}\n";
    echo "Creado en: {$tenant->createdAt}\n";
    echo "Actualizado en: {$tenant->updatedAt}\n";
    echo "Creado por: {$tenant->createdBy}\n";
    echo "========================================\n\n";

    // Convert to array and display formatted
    echo "5. DATOS EN FORMATO ARRAY:\n";
    $tenantArray = $tenant->toArray();
    echo json_encode($tenantArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

    echo "✓ Prueba completada exitosamente\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

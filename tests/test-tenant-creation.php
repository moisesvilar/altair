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
    
    echo "✓ Tenant creado exitosamente\n";
    echo "   ID del tenant creado: {$tenant->id}\n\n";

    // Get tenant data using the new method
    echo "4. Obteniendo datos del tenant creado usando getTenantById...\n";
    $retrievedTenant = $altairService->getTenantById($tenant->id);
    
    if ($retrievedTenant === null) {
        throw new \Exception("No se pudo obtener el tenant con ID: {$tenant->id}");
    }
    
    echo "✓ Datos del tenant obtenidos exitosamente\n\n";

    // Display tenant data
    echo "5. DATOS DEL TENANT OBTENIDO:\n";
    echo "========================================\n";
    echo "ID: {$retrievedTenant->id}\n";
    echo "Nombre: {$retrievedTenant->name}\n";
    echo "Slug: {$retrievedTenant->slug}\n";
    echo "Creado en: {$retrievedTenant->createdAt}\n";
    echo "Actualizado en: {$retrievedTenant->updatedAt}\n";
    echo "Creado por: {$retrievedTenant->createdBy}\n";
    echo "========================================\n\n";

    // Convert to array and display formatted
    echo "6. DATOS EN FORMATO ARRAY:\n";
    $tenantArray = $retrievedTenant->toArray();
    echo json_encode($tenantArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

    // Update tenant name
    echo "7. Actualizando nombre del tenant...\n";
    $newTenantName = 'Pero veré que puedo hacer';
    echo "   Nuevo nombre: {$newTenantName}\n";
    
    $updatedTenant = $altairService->updateTenant($retrievedTenant->id, $newTenantName);
    
    echo "✓ Tenant actualizado exitosamente\n\n";

    // Display updated tenant data
    echo "8. DATOS DEL TENANT ACTUALIZADO:\n";
    echo "========================================\n";
    echo "ID: {$updatedTenant->id}\n";
    echo "Nombre: {$updatedTenant->name}\n";
    echo "Slug: {$updatedTenant->slug}\n";
    echo "Creado en: {$updatedTenant->createdAt}\n";
    echo "Actualizado en: {$updatedTenant->updatedAt}\n";
    echo "Creado por: {$updatedTenant->createdBy}\n";
    echo "========================================\n\n";

    // Convert updated tenant to array and display formatted
    echo "9. DATOS ACTUALIZADOS EN FORMATO ARRAY:\n";
    $updatedTenantArray = $updatedTenant->toArray();
    echo json_encode($updatedTenantArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

    echo "✓ Prueba completada exitosamente\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

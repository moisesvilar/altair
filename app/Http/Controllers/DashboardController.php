<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // Aquí puedes obtener datos reales de tu base de datos
        $data = [
            'totalTenants' => 12,
            'activeUsers' => 143,
            'monthlyRevenue' => '25,890',
            'supportTickets' => 7,
            'recentTenants' => [
                [
                    'name' => 'Empresa Demo',
                    'domain' => 'demo.altair.com',
                    'status' => 'Activo',
                    'created_at' => now()->format('d/m/Y')
                ],
                [
                    'name' => 'Tech Solutions',
                    'domain' => 'tech.altair.com',
                    'status' => 'Pendiente',
                    'created_at' => now()->subDay()->format('d/m/Y')
                ]
            ]
        ];

        return view('dashboard', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Sample data for dashboard
        $stats = [
            'total_sales' => [
                'value' => '$45,678',
                'change' => '+12.5%',
                'change_type' => 'positive',
                'icon' => 'fas fa-dollar-sign'
            ],
            'total_orders' => [
                'value' => '1,234',
                'change' => '+8.2%',
                'change_type' => 'positive',
                'icon' => 'fas fa-shopping-cart'
            ],
            'total_customers' => [
                'value' => '5,678',
                'change' => '+15.3%',
                'change_type' => 'positive',
                'icon' => 'fas fa-users'
            ],
            'revenue' => [
                'value' => '$89,123',
                'change' => '+18.7%',
                'change_type' => 'positive',
                'icon' => 'fas fa-chart-line'
            ]
        ];


        // Sample recent orders
        $recentOrders = [
            [
                'id' => '#ORD-001',
                'customer' => 'John Doe',
                'amount' => '$299.99',
                'status' => 'completed',
                'date' => '2024-01-15'
            ],
            [
                'id' => '#ORD-002',
                'customer' => 'Jane Smith',
                'amount' => '$149.50',
                'status' => 'pending',
                'date' => '2024-01-14'
            ],
            [
                'id' => '#ORD-003',
                'customer' => 'Mike Johnson',
                'amount' => '$89.99',
                'status' => 'shipped',
                'date' => '2024-01-13'
            ],
            [
                'id' => '#ORD-004',
                'customer' => 'Sarah Wilson',
                'amount' => '$199.99',
                'status' => 'completed',
                'date' => '2024-01-12'
            ],
            [
                'id' => '#ORD-005',
                'customer' => 'David Brown',
                'amount' => '$79.99',
                'status' => 'cancelled',
                'date' => '2024-01-11'
            ]
        ];

        return view('dashboard.index', compact('stats', 'recentOrders'));
    }
}

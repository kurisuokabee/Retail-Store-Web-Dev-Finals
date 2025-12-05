@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    <!-- Force-load admin dashboard css -->
    @php
        $publicCssPath = public_path('css/admin/index.css');
        $resourceCssPath = resource_path('css/admin/index.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/index.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>{!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}</style>
    @endif

    {{-- <!-- Header / Navigation -->
    <header>
        @include('components.navbar')
    </header> --}}

    <main class="container admin-dashboard">
        <section class="admin-top panel">
            <div class="top-left">
                <h1>Admin Dashboard</h1>
                <p class="muted">Manage store content, orders and reports</p>
            </div>

            <div class="top-actions">
                <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-ghost">Logout</button>
                </form>
            </div>
        </section>

        {{-- compute stats fallback when controller did not pass $stats --}}
        @php
            // avoid fatal errors if facades are unavailable; use fully-qualified names
            $schemaHas = function($table){
                return \Illuminate\Support\Facades\Schema::hasTable($table);
            };

            if (!isset($stats) || !is_array($stats)) {
                $stats = [];
            }

            if (!array_key_exists('products', $stats)) {
                $stats['products'] = $schemaHas('products') ? \Illuminate\Support\Facades\DB::table('products')->count() : '—';
            }

            if (!array_key_exists('orders', $stats)) {
                $stats['orders'] = $schemaHas('orders') ? \Illuminate\Support\Facades\DB::table('orders')->count() : '—';
            }

            // NEW: compute average sales per day (30-day window) when not provided
            if (!array_key_exists('avg_daily_sales', $stats)) {
                $avg = null;
                $days = 30;
                if ($schemaHas('orders')) {
                    $ordersTable = \Illuminate\Support\Facades\DB::table('orders');
                    // try common total column names
                    $candidateCols = ['total_amount','total','amount','order_total','grand_total'];
                    $foundCol = null;
                    foreach ($candidateCols as $c) {
                        if (\Illuminate\Support\Facades\Schema::hasColumn('orders', $c)) {
                            $foundCol = $c;
                            break;
                        }
                    }

                    if ($foundCol) {
                        // sum amounts in the last $days days
                        $sum = $ordersTable->where('created_at', '>=', \Carbon\Carbon::now()->subDays($days))->sum($foundCol);
                        $avgVal = $days > 0 ? ($sum / $days) : 0;
                        $avg = '$' . number_format((float)$avgVal, 2);
                    } else {
                        // fallback: average number of orders per day over last $days
                        $count = $ordersTable->where('created_at', '>=', \Carbon\Carbon::now()->subDays($days))->count();
                        $avg = number_format(($count / max(1, $days)), 2) . ' orders/day';
                    }
                }
                $stats['avg_daily_sales'] = $avg !== null ? $avg : '—';
            }

            if (!array_key_exists('customers', $stats)) {
                if ($schemaHas('customers')) {
                    $stats['customers'] = \Illuminate\Support\Facades\DB::table('customers')->count();
                } elseif ($schemaHas('users')) {
                    // fallback to users table if customers table is not present
                    $stats['customers'] = \Illuminate\Support\Facades\DB::table('users')->count();
                } else {
                    $stats['customers'] = '—';
                }
            }

            if (!array_key_exists('low_stock', $stats)) {
                $low = null;
                // try common inventory table names and count items with low stock (<=5)
                if ($schemaHas('inventories')) {
                    $low = \Illuminate\Support\Facades\DB::table('inventories')->where('stock_quantity', '<=', 5)->count();
                } elseif ($schemaHas('inventory')) {
                    $low = \Illuminate\Support\Facades\DB::table('inventory')->where('stock_quantity', '<=', 5)->count();
                } elseif ($schemaHas('products') && $schemaHas('inventories')) {
                    $low = \Illuminate\Support\Facades\DB::table('inventories')->where('stock_quantity', '<=', 5)->count();
                }

                $stats['low_stock'] = $low !== null ? $low : '—';
            }
        @endphp

        <section class="admin-stats">
            <div class="stats-grid">
                <div class="stat">
                    <div class="stat-value">{{ $stats['products'] ?? '—' }}</div>
                    <div class="stat-label">Products</div>
                </div>
                <div class="stat">
                    <div class="stat-value">{{ $stats['orders'] ?? '—' }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat">
                    <div class="stat-value">{{ $stats['avg_daily_sales'] ?? '—' }}</div>
                    <div class="stat-label">Avg Sales / Day</div>
                </div>
                <div class="stat">
                    <div class="stat-value">{{ $stats['low_stock'] ?? '—' }}</div>
                    <div class="stat-label">Low stock</div>
                </div>
            </div>
        </section>

        <section class="admin-grid">
            <a class="admin-card" href="{{ route('admin.products.index') }}">
                <div class="card-icon">🛍️</div>
                <div class="card-body">
                    <h3>Manage Products</h3>
                    <p class="muted">Create, edit and organize product catalog</p>
                </div>
                <div class="card-cta">Open</div>
            </a>

            <a class="admin-card" href="{{ route('admin.categories.index') }}">
                <div class="card-icon">🗂️</div>
                <div class="card-body">
                    <h3>Manage Categories</h3>
                    <p class="muted">Category structure and navigation</p>
                </div>
                <div class="card-cta">Open</div>
            </a>

            <a class="admin-card" href="{{ route('admin.suppliers.index') }}">
                <div class="card-icon">🤝</div>
                <div class="card-body">
                    <h3>Manage Suppliers</h3>
                    <p class="muted">Supplier contacts and terms</p>
                </div>
                <div class="card-cta">Open</div>
            </a>

            <a class="admin-card" href="{{ route('admin.inventory.index') }}">
                <div class="card-icon">📦</div>
                <div class="card-body">
                    <h3>Inventory</h3>
                    <p class="muted">Stock levels and adjustments</p>
                </div>
                <div class="card-cta">Open</div>
            </a>

            <a class="admin-card" href="{{ route('admin.orders.index') }}">
                <div class="card-icon">🧾</div>
                <div class="card-body">
                    <h3>Orders</h3>
                    <p class="muted">Process and manage customer orders</p>
                </div>
                <div class="card-cta">Open</div>
            </a>

            <a class="admin-card" href="{{ route('admin.reports.index') }}">
                <div class="card-icon">📊</div>
                <div class="card-body">
                    <h3>Reports</h3>
                    <p class="muted">Sales and performance analytics</p>
                </div>
                <div class="card-cta">Open</div>
            </a>
        </section>
    </main>

@endsection

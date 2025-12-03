@extends('layouts.app')

@section('title', 'Reports')

@section('content')
    <!-- Force-load reports-index.css to match admin theme -->
    @php
        $publicCssPath = public_path('css/admin/reports-index.css');
        $resourceCssPath = resource_path('css/admin/reports-index.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/admin/reports-index.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/admin/reports-index.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<div class="admin-reports-page">
    <div class="admin-page-header">
        <h1>Reports</h1>
    </div>

    <div class="admin-action-bar">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
    <!-- Reports menu: allows the admin to switch which report is visible. -->
    <!-- BACKEND: No controller changes required for this client-side menu. -->
    <div class="reports-menu" role="tablist" aria-label="Reports menu">
        <!-- Buttons show friendly labels but submit no data; selection is purely visual and client-side. -->
        <button type="button" class="active" data-target="#sales-section" role="tab" aria-controls="sales-section" aria-selected="true">Sales Per Day</button>
        <button type="button" data-target="#status-section" role="tab" aria-controls="status-section" aria-selected="false">Orders Per Status</button>
        <button type="button" data-target="#inventory-section" role="tab" aria-controls="inventory-section" aria-selected="false">Inventory Summary</button>
    </div>

    <!-- Sales Per Day section -->
    <div id="sales-section" class="reports-section" role="tabpanel" aria-labelledby="sales-section-tab">
        <h2>Sales Per Day</h2>
        <div class="reports-table-wrapper">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesPerDay as $day)
                        <tr>
                            <td>{{ $day->date }}</td>
                            <td>{{ $day->total_sales }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="table-empty">No sales data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Orders Per Status section (hidden by default) -->
    <div id="status-section" class="reports-section reports-hidden" role="tabpanel" aria-labelledby="status-section-tab">
        <h2>Orders Per Status</h2>
        <div class="reports-table-wrapper">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Total Orders</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ordersPerStatus as $status)
                        <tr>
                            <td>{{ ucfirst($status->order_status) }}</td>
                            <td>{{ $status->total_orders }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="table-empty">No orders data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Inventory Summary section (hidden by default) -->
    <div id="inventory-section" class="reports-section reports-hidden" role="tabpanel" aria-labelledby="inventory-section-tab">
        <h2>Inventory Summary</h2>
        <div class="reports-table-wrapper">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock Quantity</th>
                        <th>Reorder Level</th>
                        <th>Max Stock Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventorySummary as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->inventory->stock_quantity ?? 'N/A' }}</td>
                            <td>{{ $product->inventory->reorder_level ?? 'N/A' }}</td>
                            <td>{{ $product->inventory->max_stock_level ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="table-empty">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS to toggle report sections. This is purely client-side and requires no backend change. -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Cache buttons and sections
            const buttons = document.querySelectorAll('.reports-menu button');
            const sections = document.querySelectorAll('.reports-section');

            // Helper: show only the section with given id
            function showSection(targetId, pushHash = true) {
                sections.forEach(s => {
                    if ('#' + s.id === targetId) {
                        s.classList.remove('reports-hidden');
                    } else {
                        s.classList.add('reports-hidden');
                    }
                });

                // Update active button states and aria-selected
                buttons.forEach(btn => {
                    const t = btn.getAttribute('data-target');
                    const isActive = (t === targetId);
                    btn.classList.toggle('active', isActive);
                    btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                });

                // Optionally update hash to allow deep-linking
                if (pushHash) {
                    history.replaceState(null, '', targetId);
                }
            }

            // Attach click handlers
            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    showSection(btn.getAttribute('data-target'));
                });
            });

            // If a hash is present on load, respect it (e.g., #status-section)
            if (location.hash) {
                const hash = location.hash;
                const matching = document.querySelector('.reports-menu button[data-target="' + hash + '"]');
                if (matching) {
                    showSection(hash, false);
                }
            }
        });
    </script>
</div>
@endsection

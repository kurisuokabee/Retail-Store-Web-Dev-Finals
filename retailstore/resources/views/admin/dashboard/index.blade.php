<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
<h1>Admin Dashboard</h1>

<ul>
    <li><a href="{{ route('admin.products.index') }}">Manage Products</a></li>
    <li><a href="{{ route('admin.categories.index') }}">Manage Categories</a></li>
    <li><a href="{{ route('admin.suppliers.index') }}">Manage Suppliers</a></li>
    <li><a href="{{ route('admin.inventory.index') }}">Manage Inventory</a></li>
    <li><a href="{{ route('admin.orders.index') }}">Process Orders</a></li>
    <li><a href="{{ route('admin.reports.index') }}">View Reports</a></li>
</ul>

<form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
    
</body>
</html>

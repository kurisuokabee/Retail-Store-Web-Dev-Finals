<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Admin Dashboard</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Admin Dashboard</h1>

    <!-- List of admin management options -->
    <ul>
        <!-- Link to manage products -->
        <li><a href="{{ route('admin.products.index') }}">Manage Products</a></li>
        <!-- Link to manage categories -->
        <li><a href="{{ route('admin.categories.index') }}">Manage Categories</a></li>
        <!-- Link to manage suppliers -->
        <li><a href="{{ route('admin.suppliers.index') }}">Manage Suppliers</a></li>
        <!-- Link to manage inventory -->
        <li><a href="{{ route('admin.inventory.index') }}">Manage Inventory</a></li>
        <!-- Link to process orders -->
        <li><a href="{{ route('admin.orders.index') }}">Process Orders</a></li>
        <!-- Link to view reports -->
        <li><a href="{{ route('admin.reports.index') }}">View Reports</a></li>
    </ul>

    <!-- Logout form -->
    <form method="POST" action="{{ route('admin.logout') }}">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf
        <!-- Logout button -->
        <button type="submit">Logout</button>
    </form>
    
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <!-- Sets the title of the page shown in the browser tab -->
    <title>Add Supplier</title>
</head>
<body>
    <!-- Main heading of the page -->
    <h1>Add New Supplier</h1>

    <!-- Link to go back to the suppliers list -->
    <a href="{{ route('admin.suppliers.index') }}">Back to Suppliers</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <!-- Errors are displayed in red color -->
        <div style="color: red;">
            <ul>
                <!-- Loop through all errors and display each one as a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form to add a new supplier -->
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        <!-- CSRF token for security to prevent cross-site request forgery -->
        @csrf

        <p>
            <!-- Label and input for supplier name -->
            <label>Supplier Name:</label><br>
            <input type="text" name="supplier_name" value="{{ old('supplier_name') }}" required>
        </p>

        <p>
            <!-- Label and input for contact person -->
            <label>Contact Person:</label><br>
            <input type="text" name="contact_person" value="{{ old('contact_person') }}">
        </p>

        <p>
            <!-- Label and input for email -->
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}">
        </p>

        <p>
            <!-- Label and input for phone -->
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </p>

        <p>
            <!-- Label and textarea for address -->
            <label>Address:</label><br>
            <textarea name="address">{{ old('address') }}</textarea>
        </p>

        <p>
            <!-- Submit button to add the supplier -->
            <button type="submit">Add Supplier</button>
        </p>
    </form>
</body>
</html>

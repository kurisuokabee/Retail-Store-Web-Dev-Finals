<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
</head>
<body>
<h1>Edit Supplier</h1>

<a href="{{ route('admin.suppliers.index') }}">Back to Suppliers</a>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.suppliers.update', $supplier->supplier_id) }}" method="POST">
    @csrf
    @method('PUT')

    <p>
        <label>Supplier Name:</label><br>
        <input type="text" name="supplier_name" value="{{ old('supplier_name', $supplier->supplier_name) }}" required>
    </p>

    <p>
        <label>Contact Person:</label><br>
        <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}">
    </p>

    <p>
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $supplier->email) }}">
    </p>

    <p>
        <label>Phone:</label><br>
        <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">
    </p>

    <p>
        <label>Address:</label><br>
        <textarea name="address">{{ old('address', $supplier->address) }}</textarea>
    </p>

    <p>
        <button type="submit">Update Supplier</button>
    </p>
</form>
</body>
</html>

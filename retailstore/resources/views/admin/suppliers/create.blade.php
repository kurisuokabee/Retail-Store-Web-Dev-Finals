<!DOCTYPE html>
<html>
<head>
    <title>Add Supplier</title>
</head>
<body>
<h1>Add New Supplier</h1>

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

<form action="{{ route('admin.suppliers.store') }}" method="POST">
    @csrf
    <p>
        <label>Supplier Name:</label><br>
        <input type="text" name="supplier_name" value="{{ old('supplier_name') }}" required>
    </p>

    <p>
        <label>Contact Person:</label><br>
        <input type="text" name="contact_person" value="{{ old('contact_person') }}">
    </p>

    <p>
        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}">
    </p>

    <p>
        <label>Phone:</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}">
    </p>

    <p>
        <label>Address:</label><br>
        <textarea name="address">{{ old('address') }}</textarea>
    </p>

    <p>
        <button type="submit">Add Supplier</button>
    </p>
</form>
</body>
</html>

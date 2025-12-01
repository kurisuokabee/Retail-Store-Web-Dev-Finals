@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
    <!-- Main heading -->
    <h1>Edit Supplier</h1>

    <!-- Link to return to the suppliers list -->
    <a href="{{ route('admin.suppliers.index') }}">Back to Suppliers</a>

    <!-- Display validation errors from the backend if any exist -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                <!-- Loop through all errors and show each in a list item -->
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form for editing an existing supplier -->
    <form action="{{ route('admin.suppliers.update', $supplier->supplier_id) }}" method="POST">
        <!-- CSRF token for security -->
        @csrf
        <!-- Specify that the form uses PUT method for updating -->
        @method('PUT')

        <p>
            <!-- Supplier Name input, pre-filled with old input or current value -->
            <label>Supplier Name:</label><br>
            <input type="text" name="supplier_name" value="{{ old('supplier_name', $supplier->supplier_name) }}" required>
        </p>

        <p>
            <!-- Contact Person input, pre-filled with old input or current value -->
            <label>Contact Person:</label><br>
            <input type="text" name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}">
        </p>

        <p>
            <!-- Email input, pre-filled with old input or current value -->
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email', $supplier->email) }}">
        </p>

        <p>
            <!-- Phone input, pre-filled with old input or current value -->
            <label>Phone:</label><br>
            <input type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">
        </p>

        <p>
            <!-- Address textarea, pre-filled with old input or current value -->
            <label>Address:</label><br>
            <textarea name="address">{{ old('address', $supplier->address) }}</textarea>
        </p>

        <p>
            <!-- Submit button to save changes -->
            <button type="submit">Update Supplier</button>
        </p>
    </form>
@endsection

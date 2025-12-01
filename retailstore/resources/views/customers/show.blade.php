@extends('layouts.app')

@section('title', 'Customer Details')

@section('content')

<header>
    @include('components.navbar')
</header>

<div>
    <h1>Customer Details</h1>

    <!-- Success message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Customer information -->
    <div style="margin-bottom: 20px;">
        <h2>{{ $customer->username }}</h2>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>First Name:</strong> {{ $customer->first_name }}</p>
        <p><strong>Last Name:</strong> {{ $customer->last_name }}</p>
        <p><strong>Date of Birth:</strong> {{ $customer->date_of_birth ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $customer->phone ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
        <p><strong>Account Created:</strong> {{ $customer->created_at->format('F d, Y') }}</p>
    </div>

    <!-- Delete account form -->
    <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" 
          onsubmit="return confirm('Are you sure you want to delete your account?');"
          style="margin-bottom: 15px;">
        @csrf
        @method('DELETE')
        <button type="submit" style="background-color: red; color: white; padding: 5px 10px;">
            Delete Account
        </button>
    </form>

    <!-- Edit account link -->
    <a href="{{ route('customers.edit', $customer->customer_id) }}" 
       style="display: inline-block; margin-bottom: 20px;">
       Edit Information
    </a>

    <!-- Continue shopping link -->
    <div>
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </div>
</div>
@endsection

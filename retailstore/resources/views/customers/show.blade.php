@extends('layouts.app')

@section('title', 'Budega Philippines | User Details')

@section('content')

    <!-- Force-load show-customer.css like other pages -->
    @php
        $publicCssPath = public_path('css/show-customer.css');
        $resourceCssPath = resource_path('css/show-customer.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/show-customer.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/show-customer.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<header>
    @include('components.navbar')
</header>

<main class="container">
    <section class="panel customer-card">
        <div class="customer-grid">
            <div class="profile">
                @php
                    $avatar = $customer->avatar_url ?? '/images/user-avatar.png';
                    if (!preg_match('/^https?:\\/\\//i', $avatar)) {
                        $avatar = asset(ltrim($avatar, '/'));
                    }
                    // initials fallback
                    $initials = trim( ($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '') );
                    $initials = $initials ? collect(explode(' ', $initials))->map(fn($p)=> strtoupper(substr($p,0,1)))->slice(0,2)->join('') : strtoupper(substr($customer->username,0,2));
                @endphp

                <div class="avatar-wrap">
                    <img src="{{ $avatar }}" alt="{{ $customer->username }} avatar" onerror="this.style.display='none'">
                    <div class="avatar-fallback">{{ $initials }}</div>
                </div>

                <h2 class="username">{{ $customer->username }}</h2>
                <div class="small-muted">Member since {{ $customer->created_at->format('F d, Y') }}</div>
            </div>

            <div class="info">
                <!-- Success message -->
                @if(session('success'))
                    <div class="alert alert-success" role="status">{{ session('success') }}</div>
                @endif

                <div class="info-grid">
                    <div><strong>Email</strong><div class="small-muted">{{ $customer->email }}</div></div>
                    <div><strong>First name</strong><div class="small-muted">{{ $customer->first_name ?? 'N/A' }}</div></div>
                    <div><strong>Last name</strong><div class="small-muted">{{ $customer->last_name ?? 'N/A' }}</div></div>
                    <div><strong>Date of Birth</strong><div class="small-muted">{{ $customer->date_of_birth ?? 'N/A' }}</div></div>
                    <div><strong>Phone</strong><div class="small-muted">{{ $customer->phone ?? 'N/A' }}</div></div>
                    <div><strong>Address</strong><div class="small-muted">{{ $customer->address ?? 'N/A' }}</div></div>
                </div>

                <div class="customer-actions">
                    <a href="{{ route('customers.edit', $customer->customer_id) }}" class="btn btn-ghost">Edit Information</a>

                    <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete your account?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-remove">Delete Account</button>
                    </form>
                </div>

                {{-- bottom Continue Shopping link removed (moved outside panel) --}}
            </div>
        </div>
    </section>
</main>

@endsection

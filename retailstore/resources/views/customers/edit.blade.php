<!-- filepath: c:\Users\Cian Lee\Documents\Retail-Store-Web-Dev-Finals\retailstore\resources\views\customers\edit.blade.php -->
@extends('layouts.app')

@section('title', 'Budega Philippines | Edit User Details')

@section('content')

    <!-- Force-load show-customer.css like other pages and load edit.css for form specifics -->
    @php
        $publicShowCss = public_path('css/show-customer.css');
        $resourceShowCss = resource_path('css/show-customer.css');
        $publicEditCss = public_path('css/edit.css');
        $resourceEditCss = resource_path('css/edit.css');
    @endphp

    @if (file_exists($publicShowCss))
        <link rel="stylesheet" href="{{ asset('css/show-customer.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/show-customer.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceShowCss))
        <style>{!! Illuminate\Support\Facades\File::get($resourceShowCss) !!}</style>
    @endif

    @if (file_exists($publicEditCss))
        <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/edit.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceEditCss))
        <style>{!! Illuminate\Support\Facades\File::get($resourceEditCss) !!}</style>
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
                <!-- Validation / success -->
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert-success" style="background:#fce8e8;color:#8b1b1b;">
                        @foreach ($errors->all() as $error)
                            <div class="small-muted" style="color:inherit">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Form uses the info-grid look but each cell contains a labeled input -->
                <form action="{{ route('customers.update', $customer->customer_id) }}" method="POST" class="form-grid">
                    @csrf
                    @method('PUT')

                    <div class="info-grid">
                        <div>
                            <strong>Username</strong>
                            <input class="form-input" type="text" name="username" id="username" value="{{ old('username', $customer->username) }}" required>
                        </div>

                        <div>
                            <strong>Email</strong>
                            <input class="form-input" type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required>
                        </div>

                        <div>
                            <strong>Password</strong>
                            <input class="form-input" type="password" name="password" id="password" placeholder="Leave blank to keep current">
                        </div>

                        <div>
                            <strong>First name</strong>
                            <input class="form-input" type="text" name="first_name" id="first_name" value="{{ old('first_name', $customer->first_name) }}" required>
                        </div>

                        <div>
                            <strong>Last name</strong>
                            <input class="form-input" type="text" name="last_name" id="last_name" value="{{ old('last_name', $customer->last_name) }}" required>
                        </div>

                        <div>
                            <strong>Date of Birth</strong>
                            <input class="form-input" type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}">
                        </div>

                        <div>
                            <strong>Phone</strong>
                            <input class="form-input" type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}">
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <strong>Address</strong>
                            <textarea class="form-textarea" id="address" name="address" rows="4">{{ old('address', $customer->address) }}</textarea>
                        </div>
                    </div>

                    <div class="customer-actions" style="margin-top:12px;">
                        <a href="{{ route('customers.show', $customer->customer_id) }}" class="btn btn-ghost">Cancel</a>
                        <button type="submit" class="btn btn-ghost">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection